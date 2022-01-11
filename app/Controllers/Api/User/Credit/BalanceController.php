<?php

namespace Tokenly\Wp\Controllers\Api\User\Credit;

use Tokenly\Wp\Controllers\Api\User\Controller;
use Tokenly\Wp\Interfaces\Controllers\Api\User\Credit\BalanceControllerInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface;

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
		$user->load( array( 'oauth_user.credit_account' ) );
		if (
			isset( $user->oauth_user ) &&
			$user->oauth_user instanceof OauthUserInterface === true &&
			isset( $user->oauth_user->credit_account ) &&
			$user->oauth_user->credit_account instanceof AccountCollectionInterface === true
		) {
			$account = $user->oauth_user->credit_account->to_array();
			return $account;
		} else {
			return array();
		}
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
