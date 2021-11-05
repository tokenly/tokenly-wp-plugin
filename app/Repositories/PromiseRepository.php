<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;

class PromiseRepository implements PromiseRepositoryInterface {
	public $client;
	public $user_repository;
	
	public function __construct(
		TokenpassAPIInterface $client,
		UserRepositoryInterface $user_repository
	) {
		$this->client = $client;
		$this->user_repository = $user_repository;
	}

	/**
	 * Fetches all currently promised transactions
	 * @return array $promises
	 */
	public function index() {
		$promises = $this->client->getPromisedTransactionList();
		return $promises;
	}

	/**
	 * Fetches the specific promised transaction
	 * @param $promise_id Tokenpass promise index
	 * @return array $promise
	 */
	public function show( $promise_id ) {
		$promise = $this->client->getPromisedTransaction( $promise_id );
		return $promise;
	}

	/**
	 * Updates the existing promised transaction
	 * @param $promise_id Tokenpass promise index
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
		$destination = $params['destination'] ?? null;
		if ( $destination ) {
			$tokenpass_user = $this->user_repository->show( $destination );
			if ( $tokenpass_user ) {
				$destination = 'user:' . $tokenpass_user['username'] ?? null;
			}
		}
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
	 * @param $promise_id Tokenpass promise index
	 * @return void
	 */
	public function destroy( $promise_id ) {
		$this->client->deletePromisedTransaction( $promise_id );
	}
}
