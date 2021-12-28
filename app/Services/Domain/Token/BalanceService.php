<?php

namespace Tokenly\Wp\Services\Domain\Token;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\Token\BalanceServiceInterface;

use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;

/**
 * Manages the balances
 */
class BalanceService extends DomainService implements BalanceServiceInterface {
	protected $address_service;
	protected $balance_repository;
	protected $user_service;

	public function __construct(
		AddressServiceInterface $address_service,
		BalanceRepositoryInterface $balance_repository,
		UserServiceInterface $user_service
	) {
		$this->address_service = $address_service;
		$this->balance_repository = $balance_repository;
		$this->user_service = $user_service;
	}

	/**
	 * Gets a collection of balances
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface Balances found
	 */
	public function index( array $params = array() ) {
		return $this->handle_method( __FUNCTION__, func_get_args() );
	}

	/**
	 * Implementation of the "index" method. Will only
	 * run if no cached instance was found.
	 * @param array $params Search parameters
	 * @return BalanceCollectionInterface Balances found
	 */
	protected function index_cacheable( array $params = array() ) {
		if ( isset( $params['address'] ) ) {
			$address = $params['address'];
			$address = $this->address_service->show(
				array(
					'address' => $address,
					'with'    => array( 'balance.token_meta' ),
				)
			);
			if (
				isset( $address ) &&
				$address instanceof AddressInterface &&
				isset( $address->balance ) &&
				$address->balance instanceof BalanceCollectionInterface
			) {
				return $address->balance;
			}
		} elseif ( isset( $params['user'] ) ) {
			$user = intval( $params['user'] );
			$user = $this->user_service->show(
				array(
					'id'   => $user,
					'with' => array( 'oauth_user.balance.token_meta' ),
				)
			);
			if (
				isset( $user ) &&
				$user instanceof UserInterface &&
				isset( $user->oauth_user ) &&
				$user->oauth_user instanceof OauthUserInterface &&
				isset( $user->oauth_user->balance ) &&
				$user->oauth_user->balance instanceof BalanceCollectionInterface
			) {
				return $user->oauth_user->balance;
			}
		} elseif ( isset( $params['oauth_token'] ) ) {
			$balance = $this->balance_repository->index( $params );
			return $balance;
		}
	}
}
