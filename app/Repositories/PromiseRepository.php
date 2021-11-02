<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\UserRepository;

class PromiseRepository {
	public $client;
	
	public function __construct(
		TokenpassAPI $client,
		UserRepository $user_repository
	) {
		$this->client = $client;
		$this->user_repository = $user_repository;
	}
	public function index() {
		$promises = $this->client->getPromisedTransactionList();
		return $promises;
	}

	public function show( $promise_id ) {
		$promise = $this->client->getPromisedTransaction( $promise_id );
		return $promise;
	}

	public function update( $promise_id, $params ) {
		$response = $this->client->updatePromisedTransaction( $promise_id, $params );
	}
	
	public function store( $promise ) {
		$destination = $promise['destination'] ?? null;
		if ( $destination ) {
			$tokenpass_user = $this->user_repository->show( $destination );
			if ( $tokenpass_user ) {
				$destination = 'user:' . $tokenpass_user['username'] ?? null;
			}
		}
		$quantity = $promise['quantity'] ?? null;
		if ( $quantity ) {
			//$quantity = $quantity * 100000000;
		}
		$this->client->promiseTransaction(
			$promise['source'] ?? null,
			$destination,
			$promise['asset'] ?? null,
			$quantity,
			null,
			null,
			null,
			$promise['ref'] ?? null,
			'bitcoin',
			'counterparty',
			true,
			$promise['note'] ?? null
		);
	}

	public function destroy( $promise_id ) {
		$this->client->deletePromisedTransaction( $promise_id );
	}
}
