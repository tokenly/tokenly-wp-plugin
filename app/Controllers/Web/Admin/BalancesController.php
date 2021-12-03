<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\BalancesControllerInterface;
use Tokenly\Wp\Views\Admin\BalancesShowView;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;

/**
 * Serves the admin source views
 */
class BalancesController implements BalancesControllerInterface {
	protected $balances_show_view;
	protected $address_service;

	public function __construct(
		BalancesShowView $balances_show_view,
		AddressServiceInterface $address_service
	) {
		$this->balances_show_view = $balances_show_view;
		$this->address_service = $address_service;
	}

	public function show() {
		$address = $_GET['address'] ?? null;
		if ( !isset( $_GET['address'] ) ) {
			return;
		}
		$address = $this->address_service->show(
			array(
				'address' => $_GET['address'],
				'with'    => array( 'balance.token_meta' ),
			)
		);
		if ( !$address ) {
			return;
		}
		$render = $this->balances_show_view->render( array(
			'address' => $address,
		) );
		return $render;
	}
}
