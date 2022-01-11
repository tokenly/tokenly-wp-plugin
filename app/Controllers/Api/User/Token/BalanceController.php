<?php

namespace Tokenly\Wp\Controllers\Api\User\Token;

use Tokenly\Wp\Controllers\Api\User\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\User\Token\BalanceControllerInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

/**
 * Defines promise-related endpoints
 */
class BalanceController extends Controller implements BalanceControllerInterface {
	/**
	 * Gets a collection of balance
	 * @param UserInterface $user Bound user
	 * @param \WP_REST_Request $request Request data
	 * @return array
	 */
	public function index( UserInterface $user, \WP_REST_Request $request ) {
		$user->load( array( 'oauth_user.balance.meta' ) );
		if ( !isset( $user->oauth_user ) || $user->oauth_user instanceof OauthUserInterface === false ) {
			return array();
		}
		if ( !isset( $user->oauth_user->balance ) || $user->oauth_user->balance instanceof BalanceCollectionInterface === false ) {
			return array();
		}
		$balance = $user->oauth_user->balance->to_array();
		return $balance;
	}

	/**
	 * Gets model binding parameters
	 * @return array
	 */
	protected function get_bind_params() {
		$params = array_merge( parent::get_bind_params(), array(
			'single_methods' => array( 'index' ),
		) );
		return $params;
	}
}
