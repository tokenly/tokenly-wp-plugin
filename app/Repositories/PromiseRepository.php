<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;

class PromiseRepository implements PromiseRepositoryInterface {
	protected $client;
	protected $user_repository;
	protected $promise_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserRepositoryInterface $user_repository,
		PromiseFactoryInterface $promise_factory
	) {
		$this->client = $client;
		$this->user_repository = $user_repository;
		$this->promise_factory = $promise_factory;
	}

	/**
	 * Fetches all currently promised transactions
	 * @return PromiseInterface[] Promises found
	 */
	public function index() {
		$promises = $this->client->getPromisedTransactionList();
		if ( !$promises ) {
			return;
		}
		$promises = array_map( function( $promise ) {
			return $this->promise_factory->create( $promise );
		}, $promises );
		return $promises;
	}

	/**
	 * Fetches the specific promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface Promise found
	 */
	public function show( $promise_id ) {
		$promise = $this->client->getPromisedTransaction( $promise_id );
		if ( !$promise ) {
			return;
		}
		$promise = $this->promise_factory->create( $promise );
		return $promise;
	}

	/**
	 * Updates the existing promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @param $params New promise properties
	 * @return array
	 */
	public function update( $promise_id, $params ) {
		$response = $this->client->updatePromisedTransaction( $promise_id, $params );
	}
	
	/**
	 * Creates a new promised transaction
	 * @param array $params New promise properties
	 * @return void
	 */
	public function store( $params ) {
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
		$quantity = $params['quantity'] ?? null;
		if ( $quantity ) {
			//$quantity = $quantity * 100000000;
		}
		$this->client->promiseTransaction(
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
	}

	/**
	 * Destroys the existing promise
	 * @param integer $promise_id Tokenpass promise index
	 * @return void
	 */
	public function destroy( $promise_id ) {
		$this->client->deletePromisedTransaction( $promise_id );
	}
}
