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
		$response = $this->client->getPromisedTransactionList();
		return $response;
	}
	
	public function store( $promise ) {
		$destination = $promise['destination'] ?? null;
		if ( $destination ) {
			$tokenpass_user = $this->user_repository->show( $destination );
			if ( $tokenpass_user ) {
				$destination = 'user:' . $tokenpass_user['username'] ?? null;
			}
		}
		$response = $this->client->promiseTransaction(
			$promise['source'] ?? null,
			$destination,
			$promise['asset'] ?? null,
			$promise['quantity'] ?? null,
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
}
