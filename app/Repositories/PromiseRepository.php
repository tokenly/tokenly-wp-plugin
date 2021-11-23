<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;


class PromiseRepository implements PromiseRepositoryInterface {
	protected $client;
	protected $oauth_user_repository;
	protected $promise_factory;
	protected $promise_collection_factory;
	protected $promise_meta_repository;
	protected $source_repository;
	protected $current_user;
	protected $promise_cache;
	
	public function __construct(
		TokenpassAPIInterface $client,
		OauthUserRepositoryInterface $oauth_user_repository,
		PromiseCollectionFactoryInterface $promise_collection_factory,
		PromiseMetaRepositoryInterface $promise_meta_repository,
		SourceRepositoryInterface $source_repository,
		CurrentUserInterface $current_user
	) {
		$this->client = $client;
		$this->oauth_user_repository = $oauth_user_repository;
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
		$promise = $this->client->getPromisedTransaction( $promise_id );
		if ( !$promise ) {
			return false;
		}
		$collection = $this->promise_collection_factory->create( array( $promise ) );
		if ( isset( $params['with'] ) ) {
			$collection = $this->handle_with( $collection, $params['with'] );
		}
		return $collection[0];
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
		if (
			!isset( $params['asset'] ) || 
			!isset( $params['source'] ) ||
			!isset( $params['destination'] ) ||
			!isset( $params['quantity'] ) ||
			!isset( $params['pseudo'] )
		) {
			throw new \Exception( 'Missing required parameters.' );
		}
		$asset = $params['asset'];
		$quantity = floatval( $params['quantity'] );
		$pseudo = boolval( $params['pseudo'] );
		$source = $params['source'];
		$source = $this->source_repository->show( array(
			'address' => $params['source'],
			'with'    => array( 'address' ),
		) );
		if ( !$source ||
			!isset( $source->address_data ) ||
			!isset( $source->address )
		) {
			throw new \Exception( 'Source not found or no address data.' );
		}
		$source_address = $source->address;
		$destination = $params['destination'];
		$destination_oauth_user = $this->oauth_user_repository->show( $destination );
		if ( !$destination_oauth_user ) {
			throw new \Exception( 'Destination oauth user not found.' );
		}
		$destination = $this->get_destination( $destination_oauth_user );
		if ( !$destination ) {
			throw new \Exception( 'Destination is invalid.' );
		}
		$address_data = $source->address_data;
		if (
			!isset( $address_data->type ) ||
			!isset( $address_data->balances )
		) {
			throw new \Exception( 'Address data is incomplete.' );
		}
		$type = $address_data->type;
		$balances = $address_data->balances;
		$quantity = $this->apply_precision_to_quantity( $quantity, $asset, $balances );
		$ref = $params['ref'] ?? '';
		$note = $params['note'] ?? '';
		$expiration = null;
		$txid = null;
		$fingerprint = null;
		$protocol = 'counterparty';
		$promise_data = $this->client->promiseTransaction(
			$source_address,
			$destination,
			$asset,
			$quantity,
			$expiration,
			$txid,
			$fingerprint,
			$ref,
			$type,
			$protocol,
			$pseudo,
			$note
		);
		if ( !$promise_data ) {
			throw new \Exception( 'Promise was not created on the remote server.' );
		}
		if ( !isset( $promise_data['promise_id'] ) ) {
			throw new \Exception( 'No ID on the returned promise.' );
		}
		$promise_id = $promise_data['promise_id'];
		$promise = $this->show( $promise_id );
		$promise_meta_data = array();
		$current_oauth_user = $this->current_user->get_oauth_user();
		if ( isset( $current_oauth_user->id ) ) {
			$promise_meta_data['source_user_id'] = $current_oauth_user->id;
		}
		if ( isset( $destination_oauth_user->id ) ) {
			$promise_meta_data['destination_user_id'] = $destination_oauth_user->id;
		}
		$promise_meta = $promise->add_meta( $promise_meta_data );
		if ( !$promise_meta ) {
			throw new \Exception( 'Promise meta was not added.' );
		}
		return $promise;
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
	 * Prepares user destination field for promise storage
	 * @param int $user_id WordPress user ID of the destination user
	 * @return string
	 */
	protected function get_destination( OauthUserInterface $oauth_user ) {
		if ( !isset( $oauth_user->username ) ) {
			return false;
		}
		$destination = "user:{$oauth_user->username}";
		return $destination;
	}

	/**
	 * Searches for the specified asset in balances to get its precision then
	 * applies the precision to the specified quantity
	 * @param int $quantity Quantity to apply precision to
	 * @param string $asset Asset name to get precision from
	 * @param BalanceCollectionInterface $balances Collection of balances where
	 * the asset data will be searched
	 * @return int
	 */
	protected function apply_precision_to_quantity( int $quantity, string $asset, BalanceCollectionInterface $balances ) {
		$balances = $balances->key_by_field( 'asset' );
		if ( !isset( $balances[ $asset ] ) ) {
			return $quantity;
		}
		$balance = $balances[ $asset ];
		if ( !isset( $balance->precision ) ) {
			return $quantity;
		}
		$precision = $balance->precision;
		if ( $precision > 0 ) {
			$multiplier = intval( 1 . str_repeat( 0, $precision ) );
			$quantity = $quantity * $multiplier;
		}
		return $quantity;
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
