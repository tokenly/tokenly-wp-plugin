<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\BalanceIndexViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class BalanceIndexViewModel extends DynamicViewModel implements BalanceIndexViewModelInterface {
	protected $address_service;
	protected $user_service;
	
	public function __construct(
		AddressServiceInterface $address_service,
		UserServiceInterface $user_service
	) {
		$this->address_service = $address_service;
		$this->user_service = $user_service;
	}
	
	protected function get_view_props( array $data = array() ) {
		$balance = array();
		$address = null;
		$user = null;
		if ( isset( $data['address'] ) ) {
			$address = $data['address'];
			$address = $this->address_service->show(
				array(
					'address' => $address,
					'with'    => array( 'balance.token_meta' ),
				)
			);
			if ( $address ) {
				if ( isset( $address->balance ) ) {
					$balance = $address->balance->to_array();
				}
				$type = 'address';
				$name = $address->address;
			}
		} elseif ( isset( $data['user'] ) ) {
			$user = intval( $data['user'] );
			$user = $this->user_service->show(
				array(
					'id'   => $user,
					'with' => array( 'oauth_user.balance.token_meta' ),
				)
			);
			if ( $user ) {
				if ( isset( $user->oauth_user ) && isset( $user->oauth_user->balance ) ) {
					$balance = $user->oauth_user->balance->to_array();
				}
				$type = 'user';
				$name = $user->user_nicename;
			}
		}
		return array(
			'entity'  => array(
				'type' => $type,
				'name' => $name,
			),
			'balance' => $balance,
		);
	}
}


