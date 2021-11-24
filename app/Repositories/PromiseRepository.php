<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPIInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;


class PromiseRepository implements PromiseRepositoryInterface {
	protected $client;
	protected $promise_factory;
	protected $promise_collection_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		PromiseFactoryInterface $promise_factory,
		PromiseCollectionFactoryInterface $promise_collection_factory
	) {
		$this->client = $client;
		$this->promise_factory = $promise_factory;
		$this->promise_collection_factory = $promise_collection_factory;
	}

	/**
	 * Fetches all currently promised transactions
	 * @return PromiseCollectionInterface Promises found
	 */
	public function index( array $params = array() ) {
		$promises = $this->client->getPromisedTransactionList();
		$promises = $this->promise_collection_factory->create( $promises );
		return $promises;
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
		$promise = $this->promise_factory->create( $promise );
		return $promise;
	}
	
	/**
	 * Creates a new promised transaction
	 * @param array $params New promise properties
	 * @return void
	 */
	public function store( array $params = array() ) {
		$promise_data = $this->client->promiseTransaction(
			$params['address'] ?? null,
			$params['destination'] ?? null,
			$params['asset'] ?? null,
			$params['quantity'] ?? null,
			$params['expiration'] ?? null,
			$params['txid'] ?? null,
			$params['fingerprint'] ?? null,
			$params['ref'] ?? null,
			$params['type'] ?? null,
			$params['protocol'] ?? null,
			$params['pseudo'] ?? null,
			$params['note'] ?? null
		);
		if ( !$promise_data ) {
			throw new \Exception( 'Promise was not created on the remote server.' );
		}
		if ( !isset( $promise_data['promise_id'] ) ) {
			throw new \Exception( 'No ID on the returned promise.' );
		}
		$promise = $this->promise_factory->create( $promise_data );
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
	 * Destroys the existing promise
	 * @param integer $promise_id Tokenpass promise index
	 * @return void
	 */
	public function destroy( int $promise_id ) {
		$this->client->deletePromisedTransaction( $promise_id );
	}
}
