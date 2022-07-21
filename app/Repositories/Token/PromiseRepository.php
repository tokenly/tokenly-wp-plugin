<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface;

use Tokenly\Wp\Models\Token\Promise;
use Tokenly\Wp\Collections\Token\PromiseCollection;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AssetNameFormatterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\QuantityCalculatorServiceInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class PromiseRepository extends Repository implements PromiseRepositoryInterface {
	protected TokenpassAPIInterface $client;
	protected MetaRepositoryInterface $meta_repository;
	protected PromiseMetaRepositoryInterface $promise_meta_repository;
	protected SourceRepositoryInterface $source_repository;
	protected AssetNameFormatterServiceInterface $asset_name_formatter_service;
	protected QuantityCalculatorServiceInterface $quantity_calculator_service;
	
	public function __construct(
		TokenpassAPIInterface $client,
		MetaRepositoryInterface $meta_repository,
		PromiseMetaRepositoryInterface $promise_meta_repository,
		SourceRepositoryInterface $source_repository,
		AssetNameFormatterServiceInterface $asset_name_formatter_service,
		QuantityCalculatorServiceInterface $quantity_calculator_service
	) {
		$this->client = $client;
		$this->meta_repository = $meta_repository;
		$this->promise_meta_repository = $promise_meta_repository;
		$this->source_repository = $source_repository;
		$this->asset_name_formatter_service = $asset_name_formatter_service;
		$this->quantity_calculator_service = $quantity_calculator_service;
	}

	/**
	 * Gets a collection of promises
	 * @param array $params Search parameters
	 * @return PromiseCollectionInterface Promises found
	 */
	public function index( array $params = array() ): PromiseCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single promise
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface|null Promise found
	 */
	public function show( array $params = array() ): ?PromiseInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Makes a new promise
	 * @param array $params New promise data
	 * @return PromiseInterface|null
	 */
	public function store( array $params = array() ): ?PromiseInterface {
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
			return null;
		}
		if ( !isset( $promise_data['promise_id'] ) ) {
			return null;
		}
		$promise_data = $this->format_item( $promise_data );
		$promise = ( new Promise() )->from_array( $promise_data );
		return $promise;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return PromiseCollectionInterface Promises found
	 */
	protected function index_cacheable( array $params = array() ): PromiseCollectionInterface {
		$promises = $this->client->getPromisedTransactionList();
		if ( $promises && is_array( $promises ) ) {
			foreach ( $promises as &$promise ) {
				$promise = $this->format_item( $promise );
			}
		} else {
			$promises = array();
		}
		$promises = ( new PromiseCollection() )->from_array( $promises );
		return $promises;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface|null Promise found
	 */
	protected function show_cacheable( array $params = array() ): ?PromiseInterface {
		if ( !isset( $params['promise_id'] ) ) {
			return null;
		}
		$promise_id = $params['promise_id'];
		$promise = $this->client->getPromisedTransaction( $promise_id );
		if ( !$promise ) {
			return null;
		}
		$promise = $this->format_item( $promise );
		$promise = ( new Promise() )->from_array( $promise );
		return $promise;
	}

	/**
	 * Updates the promise
	 * @param PromiseInterface $promise Target promise
	 * @param array $params Update parameters
	 * @return void
	 */
	public function update( PromiseInterface $promise, array $params = array() ): void {
		if ( isset( $params['destination'] ) ) {
			unset( $params['destination'] );
		}
		if ( isset( $params['quantity'] ) && is_array( $params['quantity'] ) ) {
			$params['quantity'] = $params['quantity']['value_sat'];
		}
		$expiration = $params['expiration'];
		if ( ( !is_numeric( $expiration ) || ( int )$expiration != $expiration ) ) {
			unset( $params['expiration'] );
		}
		$this->client->updatePromisedTransaction( $promise->promise_id, $params );
	}

	/**
	 * Destroys the promise
	 * @param PromiseInterface $promise Target promise
	 * @return void
	 */
	public function destroy( PromiseInterface $promise ): void {
		$this->load( $promise, array( 'promise_meta' ) );
		if ( $promise->promise_meta ) {
			$promise_meta = $promise->promise_meta;
			$this->promise_meta_repository->destroy( $promise_meta );
		}
		$this->client->deletePromisedTransaction( $promise->promise_id );
	}

	/**
	 * @inheritDoc
	 */
	protected function format_item( array $item ): array {
		$quantity_fields = array();
		if ( isset( $item['quantity'] ) ) {
			$quantity_fields[ 'value_sat' ] = $item['quantity'];
		}
		if ( isset( $item['precision'] ) ) {
			$quantity_fields[ 'precision' ] = $item['precision'];
		}
		if ( isset( $quantity_fields['value_sat'] ) && isset( $quantity_fields['precision'] ) ) {
			$quantity_fields['value'] = $this->quantity_calculator_service->from_sat( $quantity_fields['value_sat'], $quantity_fields['precision'] );
		}
		$item['quantity'] = $quantity_fields;
		$item['asset'] = $this->asset_name_formatter_service->split( $item['asset'] );
		$item['source_id'] = $item['source'];
		unset( $item['source'] );
		return $item;
	}

	/**
	 * Loads the promise asset meta relation
	 * @param PromiseInterface $promsie Target promise
	 * @param string[] $relations Further relations
	 * @return MetaInterface|null
	 */
	protected function load_token_meta( PromiseInterface $promise, array $relations = array() ): ?MetaInterface {
		$token_meta = $this->meta_repository->show( array(
			'with'        => $relations,
			'assets' => array( $promise->get_asset()->get_name() ), 
		) );
		return $token_meta;
	}

	/**
	 * Loads the promise meta relation
	 * @param PromiseInterface $promise Target promise
	 * @param string[] $relations Further relations
	 * @return PromiseMetaInterface|null
	 */
	protected function load_promise_meta( PromiseInterface $promise, array $relations = array() ): ?PromiseMetaInterface {
		$promise_meta = $this->promise_meta_repository->show( array(
			'with'        => $relations,
			'promise_ids' => array( $promise->get_promise_id() ), 
		) );
		return $promise_meta;
	}

	/**
	 * Loads the source relation
	 * @param PromiseInterface $promise Target promise
	 * @param string[] $relations Further relations
	 * @return SourceInterface|null
	 */
	protected function load_source( PromiseInterface $promise, array $relations ): ?SourceInterface {
		$source = $this->source_repository->show( array(
			'address' => $promise->get_source_id(),
			'with'    => $relations,
		) );
		return $source;
	}
}
