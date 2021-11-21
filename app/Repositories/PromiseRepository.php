<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

class PromiseRepository implements PromiseRepositoryInterface {
	protected $client;
	protected $user_repository;
	protected $promise_factory;
	protected $promise_collection_factory;
	protected $promise_meta_repository;
	protected $source_repository;
	protected $current_user;
	protected $promise_cache;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserRepositoryInterface $user_repository,
		PromiseFactoryInterface $promise_factory,
		PromiseCollectionFactoryInterface $promise_collection_factory,
		PromiseMetaRepositoryInterface $promise_meta_repository,
		SourceRepositoryInterface $source_repository,
		CurrentUserInterface $current_user
	) {
		$this->client = $client;
		$this->user_repository = $user_repository;
		$this->promise_factory = $promise_factory;
		$this->promise_collection_factory = $promise_collection_factory;
		$this->promise_meta_repository = $promise_meta_repository;
		$this->source_repository = $source_repository;
		$this->current_user = $current_user;
	}

	/**
	 * Fetches all currently promised transactions
	 * @return PromiseInterface[] Promises found
	 */
	public function index( array $params = array() ) {
		if ( isset( $this->promise_cache ) ) {
			$promises = $this->promise_cache;
		} else {
			$promises = $this->client->getPromisedTransactionList() ?? array();
			$this->promise_cache = $promises;
		}
		$collection = $this->promise_collection_factory->create( $promises );
		if ( isset( $params['with'] ) ) {
			$collection = $this->handle_with( $collection, $params['with'] );
		}
		return $collection;
	}

	/**
	 * Fetches the specific promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface Promise found
	 */
	public function show( int $promise_id, array $params = array() ) {
		$promises = $this->index( $params );
		$promises->key_by_field( 'promise_id' );
		$promise = $promises[ $promise_id ] ?? null;
		return $promise;
	}

	/**
	 * Updates the existing promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @param $params New promise properties
	 * @return array
	 */
	public function update( int $promise_id, array $params = array() ) {
		$response = $this->client->updatePromisedTransaction( $promise_id, $params );
	}
	
	/**
	 * Creates a new promised transaction
	 * @param array $params New promise properties
	 * @return void
	 */
	public function store( array $params = array() ) {
		$user_id = $params['destination'] ?? null;
		if ( !$user_id ) {
			return;
		}
		$user = $this->user_repository->show( array( 
			'id' => $user_id,
		) );
		if ( !$user ) {
			return;
		}
		$profile = $user->get_oauth_user();
		if ( !$profile ) {
			return;
		}
		$destination = 'user:' . $profile->username ?? null;
		if ( isset( $params['source'] ) ) {
			$source = $this->source_repository->show( array(
				'address' => $params['source'],
				'with'    => array( 'address' ),
			) );
			if ( $source ) {
				$address_data = $source->address_data;
				if ( $address_data ) {
					$balances = $address_data->balances;
					if ( $balances ) {
						$balances = $balances->key_by_field( 'asset' );
						$balance = $balances[ $params['asset'] ] ?? null;
						if ( $balance ) {
							$precision = $balance->precision ?? 0;
							$quantity = $params['quantity'] ?? null;
							if ( $precision > 0 ) {
								$multiplier = intval( 1 . str_repeat( 0, $precision ) );
								$quantity = $quantity * $multiplier;
							}
						}
					}
				}
			}
		}
		$promise_data = $this->client->promiseTransaction(
			$params['source'] ?? null,
			$destination,
			$params['asset'] ?? null,
			$quantity,
			null,
			null,
			null,
			$params['ref'] ?? null,
			'bitcoin',
			'counterparty',
			true,
			$params['note'] ?? null
		);
		if ( !$promise_data ) {
			return;
		}
		$promise = $this->promise_factory->create( $promise_data );
		$current_user_profile = $this->current_user->get_oauth_user();
		$this->promise_meta_repository->store( array(
			'promise_id'          => $promise->promise_id,
			'source_user_id'      => $current_user_profile->id,
			'destination_user_id' => $profile->id,
		) );
	}

	/**
	 * Destroys the existing promise
	 * @param integer $promise_id Tokenpass promise index
	 * @return void
	 */
	public function destroy( int $promise_id ) {
		$this->client->deletePromisedTransaction( $promise_id );
	}
	
	/**
	 * Handles queries using parameter 'with'
	 * @param PromiseCollectionInterface $promises Queried promises
	 * @return PromiseCollectionInterface Modified promises
	 */
	protected function handle_with( PromiseCollectionInterface $promises, array $with = array() ) {
		foreach ( $with as $with_rule ) {
			$with_rule = explode( '.', $with_rule );
			switch( $with_rule[0] ?? null ) {
				case 'meta':
					if ( count( $with_rule ) > 1 ) {
						unset( $with_rule[0] );
						$with_rule = implode( '.', $with_rule );
					}
					$promises = $this->handle_with_meta( $promises, array( $with_rule ) );
					break;
			}
		}
		return $promises;
	}

	/**
	 * Appends promise meta objects to the queried promises (part of 'with' handler)
	 * @param PromiseCollectionInterface $promises Queried promises
	 * @return PromiseCollectionInterface Modified promises
	 */
	protected function handle_with_meta( PromiseCollectionInterface $promises, $with_rule ) {
		$promise_ids = array_map( function( $promise ) {
			return $promise->promise_id;	
		}, ( array ) $promises );
		$promise_meta = $this->promise_meta_repository->index( array(
			'with'        => $with_rule,
			'promise_ids' => $promise_ids, 
		) );
		$promise_meta->key_by_promise_id();
		foreach ( ( array )$promises as &$promise ) {
			$promise_id = $promise->promise_id;
			$promise->promise_meta = $promise_meta[ $promise_id ] ?? array();
		}
		return $promises;
	}
}
