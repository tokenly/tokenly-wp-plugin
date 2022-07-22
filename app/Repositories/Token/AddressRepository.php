<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\Repository;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface;

use Tokenly\Wp\Collections\Token\AddressCollection;
use Tokenly\Wp\Collections\Token\BalanceCollection;
use Tokenly\Wp\Models\Token\Address;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AssetNameFormatterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\QuantityCalculatorServiceInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

/**
 * Manages blockchain addresses
 */
class AddressRepository extends Repository implements AddressRepositoryInterface {
	protected TokenpassAPIInterface $client;
	protected BalanceRepositoryInterface $balance_repository;
	protected AssetNameFormatterServiceInterface $asset_name_formatter_service;
	protected QuantityCalculatorServiceInterface $quantity_calculator_service;
	
	public function __construct(
		TokenpassAPIInterface $client,
		BalanceRepositoryInterface $balance_repository,
		AssetNameFormatterServiceInterface $asset_name_formatter_service,
		QuantityCalculatorServiceInterface $quantity_calculator_service
	) {
		$this->client = $client;
		$this->balance_repository = $balance_repository;
		$this->asset_name_formatter_service = $asset_name_formatter_service;
		$this->quantity_calculator_service = $quantity_calculator_service;
	}

	/*
	 * Gets a collection of addresses
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	public function index(
		array $params = array() ): AddressCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/*
	 * Gets a collection of user addresses
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	public function index_user(
		array $params = array() ): AddressCollectionInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single address
	 * @param array $params Search parameters
	 * @return AddressInterface|null Address found
	 */
	public function show( array $params = array() ): ?AddressInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Gets a single user address
	 * @param array $params Search parameters
	 * @return AddressInterface|null Address found
	 */
	public function show_user( array $params = array() ): ?AddressInterface {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Makes a new address
	 * @param array $params New address data
	 * @return AddressInterface|null
	 */
	public function store( array $params = array() ): ?AddressInterface {
		if ( !isset( $params['address'] ) ) {
			throw new \Exception( 'Missing required parameters.' );
		}
		$address_data = $this->client->registerAddress(
			$params['address'],
			$params['oauth_token'],
			$params['label']  ?? 'New address',
			$params['public'] ?? false,
			$params['active'] ?? true,
			$params['type']   ?? 'bitcoin'
		);
		if ( !$address_data ) {
			return null;
		}
		$address = ( new Address() )->from_array( $address_data );
		return $address;
	}

	/**
	 * Verifies the address
	 * @return void
	 */
	public function verify(
		AddressInterface $address, array $params = array() ): void {
		$this->client->verifyAddress(
			$params['address'] ?? $address->address,
			$params['oauth_token'],
			$params['signature'],
		);
	}

	/**
	 * Updates the address
	 * @param array $params New address properties
	 * @return AddressInterface|null
	 */
	public function update( 
		AddressInterface $address,
		array $params = array() ): ?AddressInterface {
		$address_data = $this->client->updateAddressDetails(
			$params['address'] ?? $address->address,
			$params['oauth_token'],
			$params['label']  ?? $address->label,
			$params['public'] ?? $address->public,
			$params['active'] ?? $address->active
		);
		if ( !$address_data ) {
			return null;
		}
		$address = ( new Address() )->from_array( $address_data );
		return $address;
	}

	/**
	 * Deletes the model
	 * @return void
	 */
	public function destroy(
		AddressInterface $address, 
		array $params = array()
	): void {
		$this->client->deleteAddress(
			$address->address,
		 	$params['oauth_token']
		);
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	protected function index_cacheable( 
		array $params = array() ): AddressCollectionInterface {
		$addresses = array();
		if ( isset( $params['oauth_token'] ) ) {
			$oauth_token = $params['oauth_token'];
			$addresses = 
				$this->client->getAddressesForAuthenticatedUser(
					$oauth_token
				);
		}
		$addresses = ( new AddressCollection() )->from_array( $addresses );
		$addresses = $this->handle_registered( $addresses, $params );
		return $addresses;
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface Addresses found
	 */
	protected function index_user_cacheable(
		OauthUserInterface $user = null,
		array $params = array() ): AddressCollectionInterface {
		if ( $user ) {
			$params['username'] = $user->username;
		}
		$addresses = array();
		if ( isset( $params['username'] ) ) {
			$username = $params['username'];
			$addresses = $this->client->getPublicAddresses( $username );
			if ( $addresses && is_array( $addresses ) ) {
				foreach ( $addresses as &$address ) {
					$address = $this->format_item( $address );
				}
			}
		}
		$addresses = ( new AddressCollection() )->from_array( $addresses );
		$addresses = $this->handle_registered( $addresses, $params );
		return $addresses;
	}

	/**
	 * Implementation of the "show" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AddressInterface|null Address found
	 */
	protected function show_cacheable(
		array $params = array() ): ?AddressInterface {
		if ( !isset( $params['address'] ) ) {
			return null;
		}
		if ( !isset( $params['address'] ) ||
			!isset( $params['oauth_token'] )
		) {
			return null;
		}
		$address_id = $params['address'];
		$oauth_token = $params['oauth_token'];
		$address = $this->client->getAddressDetailsForAuthenticatedUser( 
			$address_id, $oauth_token );
		if ( !$address || !is_array( $address ) ) {
			return null;
		}
		$address = $this->format_item( $address );
		$address = ( new Address() )->from_array( $address );
		return $address;
	}

	/**
	 * Implementation of the "show_user" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return AddressInterface|null Address found
	 */
	protected function show_user_cacheable(
		array $params = array() ): ?AddressInterface {
		if ( !isset( $params['address'] ) || !isset( $params['username'] ) ) {
			return null;
		}
		if ( !isset( $params['username'] ) || !isset( $params['address'] ) ) {
			return null;
		}
		$username = $params['username'];
		$address_id = $params['address'];
		$address = $this->client->getPublicAddressDetails(
			$username,
			$address_id
		);
		if ( !$address ){
			return null;
		}
		$address = $this->format_item( $address );
		$address = ( new Address() )->from_array( $address );
		return $address;
	}

	/**
	 * Handles the "registered" parameter
	 * @param AddressCollectionInterface $addresses Address collection
	 * @param array $params Search parameters
	 * @return AddressCollectionInterface
	 */
	protected function handle_registered(
		AddressCollectionInterface $addresses,
		array $params
	): AddressCollectionInterface {
		if ( isset( $params['registered'] ) &&
			$params['registered'] == true
		) {
			$addresses->filter_registered();
			$addresses->key_by_field( 'address' );
		}
		return $addresses;
	}

	/**
	 * @inheritDoc
	 */
	protected function format_item( array $item ): array {
		if ( isset( $item['balances'] ) && is_array( $item['balances'] ) ) {
			foreach ( $item['balances'] as $key => &$balance ) {
				$balance['asset'] = 
					$this->asset_name_formatter_service->split( $key );
				$balance['name'] = $key;
				$balance['quantity'] = array(
					'value'     => 
						$this->quantity_calculator_service->from_sat(
							 $balance['value'], $balance['precision'] ),
					'value_sat' => $balance['value'],
					'precision' => $balance['precision'],
				);
				unset( $balance['value'] );
			}
			$item['balance'] = $item['balances'];
			unset( $item['balances'] );
			$balances = array_values( $item['balance'] );
			$balance_collection = 
				( new BalanceCollection() )->from_array( $balances );
			$item['balance'] = $balance_collection;
		}
		return $item;
	}

	/**
	 * Loads the balance relation
	 * @param string[] $relations Further relations
	 * @return BalanceCollectionInterface
	 */
	protected function load_balance(
		AddressInterface $address,
		array $relations = array()
	): BalanceCollectionInterface {
		$balance = $address->balance;
		if ( !$balance ) {
			$balance = new BalanceCollection( array() );
		}
		return $balance;
	}
}
