<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Factories\Factory;

class UserFactory extends Factory implements UserFactoryInterface {
	/**
	 * Creates a new user
	 * @param \WP_User $user WordPress user
	 * @return UserInterface
	 */
	public function create( $data, $args = array() ) {
		$user = $this->factory->create( array(
			'user' => $data,
		) );
		return $user;
	}
}
