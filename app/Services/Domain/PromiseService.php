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
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Manages the promises
 */
class PromiseService extends DomainService implements PromiseServiceInterface {
	protected $promise_repository;
	protected $promise_meta_service;
	protected $source_service;
	protected $oauth_user_service;
	protected $current_user;

	public function __construct(
		PromiseRepositoryInterface $promise_repository,
		PromiseMetaServiceInterface $promise_meta_service,
		SourceServiceInterface $source_service,
		OauthUserServiceInterface $oauth_user_service,
		CurrentUserInterface $current_user
	) {
		$this->promise_repository = $promise_repository;
		$this->promise_meta_service = $promise_meta_service;
		$this->source_service = $source_service;
		$this->oauth_user_service = $oauth_user_service;
		$this->current_user = $current_user;
	}

	/**
	 * Fetches all currently promised transactions
	 * @param array $params Search parameters
	 * @return PromiseCollectionInterface Promises found
	 */
	protected function _index( array $params = array() ) {
		$promises = $this->promise_repository->index();
		return $promises;
	}

	/**
	 * Fetches the specific promised transaction
	 * @param integer $promise_id Tokenpass promise index
	 * @return PromiseInterface Promise found
	 */
	protected function _show( array $params = array() ) {
		if ( !isset( $params['promise_id'] ) ) {
			return false;
		}
		$promise_id = $params['promise_id'];
		$promise = $this->promise_repository->show( $promise_id );
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
			!isset( $params['source_id'] ) ||
			!isset( $params['destination'] ) ||
			!isset( $params['quantity'] ) ||
			!isset( $params['pseudo'] )
		) {
			throw new \Exception( 'Missing required parameters.' );
		}
		$asset = $params['asset'];
		$quantity = floatval( $params['quantity'] );
		$pseudo = boolval( $params['pseudo'] );
		$source_id = $params['source_id'];
		$source = $this->source_service->show( array(
			'address' => $source_id,
			'with'    => array( 'address' ),
		) );
		if ( !$source ||
			!isset( $source->address) ||
			!isset( $source->address_id )
		) {
			throw new \Exception( 'Source not found or no address data.' );
		}
		$address_id = $source->address_id;
		$destination = $params['destination'];
		$destination_oauth_user = $this->oauth_user_service->show( array( 'id' => $destination ) );
		if ( !$destination_oauth_user ) {
			throw new \Exception( 'Destination oauth user not found.' );
		}
		$destination = $this->get_destination( $destination_oauth_user );
		if ( !$destination ) {
			throw new \Exception( 'Destination is invalid.' );
		}
		$address = $source->address;
		if (
			!isset( $address->type ) ||
			!isset( $address->balance )
		) {
			throw new \Exception( 'Address is incomplete.' );
		}
		$type = $address->type;
		$balance = $address->balance;
		$quantity = $this->apply_precision_to_quantity( $quantity, $asset, $balance );
		$ref = $params['ref'] ?? '';
		$note = $params['note'] ?? '';
		$expiration = null;
		$txid = null;
		$fingerprint = null;
		$protocol = 'counterparty';
		$promise = $this->promise_repository->store( array(
			'address'     => $address_id,
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
		$promise_meta_data['promise_id'] = $promise->promise_id;
		$this->current_user->load( array( 'oauth_user' ) );
		$current_oauth_user = $this->current_user->oauth_user;
		if ( isset( $current_oauth_user->id ) ) {
			$promise_meta_data['source_user_id'] = $current_oauth_user->id;
		}
		if ( isset( $destination_oauth_user->id ) ) {
			$promise_meta_data['destination_user_id'] = $destination_oauth_user->id;
		}
		$promise_meta = $this->promise_meta_service->store( $promise_meta_data );
		$promise->associate_meta( $promise_meta );
		return $promise;
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
	 * Searches for the specified asset in balance to get its precision then
	 * applies the precision to the specified quantity
	 * @param int $quantity Quantity to apply precision to
	 * @param string $asset Asset name to get precision from
	 * @param BalanceCollectionInterface $balance Collection of balance where
	 * the asset data will be searched
	 * @return int
	 */
	protected function apply_precision_to_quantity( int $quantity, string $asset, BalanceCollectionInterface $balance ) {
		$balance = $balance->key_by_field( 'asset' );
		if ( !isset( $balance[ $asset ] ) ) {
			return $quantity;
		}
		$balance = $balance[ $asset ];
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
