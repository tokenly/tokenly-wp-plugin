<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;

class PromiseRepository {
	public $client;
	
	public function __construct(
		TokenpassAPI $client
	) {
		$this->client = $client;
	}
	public function index() {
		$response = $this->client->getPromisedTransactionList();
		error_log( print_r( $response, true ) );
		return $response;
	}
	
	public function store( $promise ) {
		$response = $this->client->promiseTransaction(
			$promise['source'] ?? null,
			$promise['destination'] ?? null,
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
		error_log(print_r( $response, true ));
	}
}
