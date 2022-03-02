<?php

namespace Tokenly\Wp\Services\Application\Token;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Token\VendorServiceInterface;

use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\QuantityCalculatorServiceInterface;

class VendorService extends Service implements VendorServiceInterface {
	protected SourceRepositoryInterface $source_repository;
	protected PromiseRepositoryInterface $promise_repository;
	protected OauthUserRepositoryInterface $oauth_user_repository;
	protected UserRepositoryInterface $user_repository;
	protected PromiseMetaRepositoryInterface $promise_meta_repository;
	protected QuantityCalculatorServiceInterface $quantity_calculator_service;

	public function __construct(
		SourceRepositoryInterface $source_repository,
		PromiseRepositoryInterface $promise_repository,
		OauthUserRepositoryInterface $oauth_user_repository,
		UserRepositoryInterface $user_repository,
		PromiseMetaRepositoryInterface $promise_meta_repository,
		QuantityCalculatorServiceInterface $quantity_calculator_service
	) {
		$this->source_repository = $source_repository;
		$this->promise_repository = $promise_repository;
		$this->oauth_user_repository = $oauth_user_repository;
		$this->user_repository = $user_repository;
		$this->promise_meta_repository = $promise_meta_repository;
		$this->quantity_calculator_service = $quantity_calculator_service;
	}

	public function promise( array $params = array() ) {
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
		$current_user = $this->user_repository->show_current();
		$source = $this->source_repository->show( array(
			'address'     => $params['source_id'],
			'with'        => array( 'address' ),
			'oauth_token' => $current_user->get_oauth_token(),
		) );
		if ( 
			!$source ||
			!$source->get_address() ||
			!$source->get_address_id()
		) {
			throw new \Exception( 'Source not found or no address data.' );
		}
		$address_id = $source->get_address_id();
		$username = $params['destination'];
		$destination_user = $this->user_repository->show( array(
			'name' => $username,
			'with' => array( 'oauth_user' ),
		) );
		if ( $destination_user && $destination_user->get_oauth_user() ) {
			$username = $destination_user->get_oauth_user()->get_username();
		}
		$destination = $this->get_promise_destination( $username );
		if ( !$destination ) {
			throw new \Exception( 'Destination is invalid.' );
		}
		$address = $source->get_address();
		if (
			!$address->get_type() ||
			!$address->get_balance()
		) {
			throw new \Exception( 'Address is incomplete.' );
		}
		$balance = $address->get_balance();
		$quantity = $this->apply_precision_to_quantity( $quantity, $asset, $balance );
		$promise = $this->promise_repository->store( array(
			'address'     => $address_id,
			'destination' => $destination,
			'asset'       => $asset,
			'quantity'    => $quantity,
			'expiration'  => null,
			'txid'        => null,
			'fingerprint' => null,
			'ref'         => $params['ref'] ?? '',
			'type'        => $address->get_type(),
			'protocol'    => 'counterparty',
			'pseudo'      => $pseudo,
			'note'        => $params['note'] ?? '',
		) );
		if ( !$promise ) {
			return null;
		}
		$this->generate_promise_meta( $promise, $current_user, $destination_user );
		return $promise;
	}

	protected function generate_promise_meta( PromiseInterface $promise, UserInterface $current_user = null, UserInterface $destination_user = null ) {
		$meta = array();
		$meta['promise_id'] = $promise->get_promise_id();
		if ( $current_user ) {
			$meta['source_user_id'] = $current_user->get_uuid();
		}
		if ( $destination_user->get_uuid() ) {
			$meta['destination_user_id'] = $destination_user->get_uuid();
		}
		$meta = $this->promise_meta_repository->store( $meta );
		$this->promise_meta_repository->associate( $meta, $promise );
		return $promise;
	}
	
	protected function get_promise_destination( string $username ): ?string {
		$destination = "user:{$username}";
		return $destination;
	}

	/**
	 * Searches for the specified asset in balance to get its precision then
	 * applies the precision to the specified quantity
	 * @param float $quantity Quantity to apply precision to
	 * @param string $asset Asset name to get precision from
	 * @param BalanceCollectionInterface $balance Collection of balance where
	 * the asset data will be searched
	 * @return float
	 */
	protected function apply_precision_to_quantity( int $quantity, string $asset, BalanceCollectionInterface $balance ): float {
		$balance = clone $balance;
		$balance = $balance->key_by_asset_name();
		if ( !isset( $balance[ $asset ] ) ) {
			return $quantity;
		}
		$balance = $balance[ $asset ];
		if ( !$balance->get_quantity() ) {
			return $quantity;
		}
		$precision = $balance->get_quantity()->get_precision();
		$quantity = $this->quantity_calculator_service->to_sat( $quantity, $precision );
		return $quantity;
	}
}
