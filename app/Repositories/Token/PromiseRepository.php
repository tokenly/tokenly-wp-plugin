<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\QuantityFactoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class PromiseRepository implements PromiseRepositoryInterface {
	protected $client;
	protected $promise_factory;
	protected $promise_collection_factory;
	protected $quantity_factory;
	
	public function __construct(
		TokenpassAPIInterface $client,
		PromiseFactoryInterface $promise_factory,
		PromiseCollectionFactoryInterface $promise_collection_factory,
		QuantityFactoryInterface $quantity_factory
	) {
		$this->client = $client;
		$this->promise_factory = $promise_factory;
		$this->promise_collection_factory = $promise_collection_factory;
		$this->quantity_factory = $quantity_factory;
	}

	/**
	 * Fetches all currently promised transactions
	 * @return PromiseCollectionInterface Promises found
	 */
	public function index() {
		$promises = $this->client->getPromisedTransactionList();
		foreach ( $promises as &$promise ) {
			$promise = $this->remap_fields( $promise );
		}
		$promises = $this->promise_collection_factory->create( $promises );
		return $promises;
	}

	/**
	 * Fetches the specific promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface Promise found
	 */
	public function show( int $promise_id ) {
		$promise = $this->client->getPromisedTransaction( $promise_id );
		if ( !$promise ) {
			return false;
		}
		
		$promise = $this->remap_fields( $promise );

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
	 * @param PromiseInterface $promise Promise to update
	 * @param $params New promise properties
	 * @return array
	 */
	public function update( PromiseInterface $promise, array $params = array() ) {
		$response = $this->client->updatePromisedTransaction( $promise->promise_id, $params );
	}

	/**
	 * Destroys the existing promise
	 * @param PromiseInterface $promise Promise to destroy
	 * @return void
	 */
	public function destroy( PromiseInterface $promise ) {
		$this->client->deletePromisedTransaction( $promise->promise_id );
	}

	protected function remap_fields( array $promise ) {
		$quantity_fields = array();
		if ( isset( $promise['quantity'] ) ) {
			$quantity_fields[ 'value_sat' ] = $promise['quantity'];
		}
		if ( isset( $promise['precision'] ) ) {
			$quantity_fields[ 'precision' ] = $promise['precision'];
		}
		$promise['quantity'] = $this->quantity_factory->create( $quantity_fields );
		$promise['source_id'] = $promise['source'];
		unset( $promise['source'] );
		return $promise;
	}
}
