<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\BalancesControllerInterface;
use Tokenly\Wp\Views\Admin\BalancesShowView;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Serves the admin source views
 */
class BalancesController implements BalancesControllerInterface {
	protected $balances_show_view;
	
	public function __construct(
		BalancesShowView $balances_show_view,
		CurrentUserInterface $current_user
	) {
		$this->balances_show_view = $balances_show_view;
		$this->current_user = $current_user;
	}

	public function show() {
		$address = $_GET['address'] ?? null;
		if ( !isset( $this->current_user ) ) {
			return;
		}
		$addresses = $this->current_user->get_addresses(
			array(
				'with' => array( 'balances.meta' ),
			)
		);
		$addresses->key_by_field( 'address' );
		$addresses = $addresses->to_array();
		$address = $addresses[ $address ] ?? null;
		if ( !$address ) {
			return;
		}
		$render = $this->balances_show_view->render( array(
			'address' => $address,
		) );
		return $render;
	}
}
