<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Factories\Factory;

class UserFactory extends Factory implements UserFactoryInterface {
	/**
	 * Creates a new user
	 * @param \WP_User $user WordPress user
	 * @return UserInterface
	 */
	public function create( $user_data ) {
		$user = $this->factory->create( array(
			'user' => $user_data['user'] ?? null,
		) );
		return $user;
	}
}
