<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Factories\Factory;

class OauthUserFactory extends Factory implements OauthUserFactoryInterface {
	/**
	 * Creates a new user decorator
	 * @param array $oauth_user Oauth user data
	 * @return OauthUserInterface
	 */
	public function create( $oauth_user_data ) {
		$oauth_user = $this->factory->create( array(
			'oauth_user_data' => $oauth_user_data,
		) );
		return $oauth_user;
	}
}
