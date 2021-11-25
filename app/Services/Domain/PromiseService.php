<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class PromiseService extends DomainService implements PromiseServiceInterface {
	protected $promise_cache = array();
	protected $promise_collection_cache;
	protected $promise_repository;
	protected $promise_meta_service;
	protected $source_service;
	protected $oauth_user_service;

	public function __construct(
		PromiseRepositoryInterface $promise_repository,
		PromiseMetaServiceInterface $promise_meta_service,
		SourceServiceInterface $source_service,
		OauthUserServiceInterface $oauth_user_service
	) {
		$this->promise_repository = $promise_repository;
		$this->promise_meta_service = $promise_meta_service;
		$this->source_service = $source_service;
		$this->oauth_user_service = $oauth_user_service;
	}

	/**
	 * Fetches all currently promised transactions
	 * @return PromiseInterface[] Promises found
	 */
	public function index( array $params = array() ) {
		$promise_collection;
		if ( isset( $this->promise_collection_cache ) ) {
			$promise_collection = $this->promise_collection_cache;
		} else {
			$promise_collection = $this->promise_repository->index();
			$this->promise_collection_cache = $promise_collection;
		}
		if ( isset( $params['with'] ) ) {
			$promise_collection = $this->load( $promise_collection, $params['with'] );
		}
		return $promise_collection;
	}

	/**
	 * Fetches the specific promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface Promise found
	 */
	public function show( int $promise_id, array $params = array() ) {
		if ( isset( $this->promise_cache[ $promise_id ] ) ) {
			$promise = $this->promise_cache[ $promise_id ];
		} else {
			$promise = $this->promise_repository->show( $promise_id );
			$this->promise_cache[ $promise_id ] = $promise;
		}
		if ( !$promise ) {
			return false;
		}
		if ( isset( $params['with'] ) ) {
			$promise = $this->load( $promise, $params['with'] );
		}
		return $promise;
	}

	/**
	 * Updates the existing promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @param $params New promise properties
	 * @return PromiseInterface
	 */
	public function update( int $promise_id, array $params = array() ) {
		$promise = $this->promise_repository->update( $promise_id, $params );
		return $promise;
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
		$source = $this->source_service->show( array(
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
		$destination_oauth_user = $this->oauth_user_service->show( $destination );
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
		$promise = $this->promise_repository->store( array(
			'address'     => $source_address,
			'destination' => $destination,
			'asset'       => $asset,
			'quantity'    => $quantity,
			'expiration'  => $expiration,
			'txid'        => $txid,
			'fingerprint' => $fingerprint,
			'ref'         => $ref,
			'type'        => $type,
			'protocol'    => $protocol,
			'pseudo'      => $pseudo,
			'note'        => $note,
		) );
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
		$this->promise_repository->destroy( $promise_id );
	}

	protected function load_promise_meta( PromiseInterface $promise, array $relation ) {
		$promise_meta = $this->promise_meta_service->show( array(
			'with'        => $relation,
			'promise_ids' => array( $promise->promise_id ), 
		) );
		if ( !$promise_meta ) {
			return $promise;
		}
		$promise->promise_meta = $promise_meta;
		return $promise;
	}

	protected function load_promise_meta_collection( PromiseCollectionInterface $promise_collection, array $relation ) {
		$promise_ids = array_map( function( $promise ) {
			return $promise->promise_id;	
		}, ( array ) $promise_collection );
		$promise_meta = $this->promise_meta_service->index( array(
			'with'        => $relation,
			'promise_ids' => $promise_ids, 
		) );
		$promise_meta->key_by_promise_id();
		foreach ( ( array ) $promise_collection as &$promise ) {
			$promise_id = $promise->promise_id;
			$promise->promise_meta = $promise_meta[ $promise_id ] ?? array();
		}
		return $promise_collection;
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


}
