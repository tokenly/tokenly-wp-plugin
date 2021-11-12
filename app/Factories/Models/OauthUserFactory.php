<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Factories\Factory;

class OauthUserFactory extends Factory implements OauthUserFactoryInterface {
	/**
	 * Creates a new user decorator
	 * @param array $oauth_user Oauth user data
	 * @return OauthUserInterface
	 */
	public function create( $data, $args = array() ) {
		$oauth_user = $this->factory->create( array(
			'oauth_user_data' => $data,
		) );
		return $oauth_user;
	}
}
