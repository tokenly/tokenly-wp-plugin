<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Decorators\UserDecoratorInterface;
use Tokenly\Wp\Factories\Factory;

class UserFactory extends Factory implements UserFactoryInterface {
	/**
	 * Creates a new user decorator
	 * @param \WP_User $user WordPress user
	 * @param array $tokenpass_user Tokenpass user data
	 * @return UserDecoratorInterface
	 */
	public function create( $params ) {
		$instance = $this->factory->create( array(
			'user'           => $params['user'] ?? null,
			'tokenpass_user' => $params['tokenpass_user'] ?? null,
		) );
		return $instance;
	}
}
