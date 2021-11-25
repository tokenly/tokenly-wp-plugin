<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Factories\Factory;

class PostFactory extends Factory implements PostFactoryInterface {
	/**
	 * Creates a new post object
	 * @param array $data New token meta data
	 * @param array $args Additional parameters
	 * @return PostInterface
	 */
	public function create( $data, $args = array() ) {
		$post = $this->factory->create( array(
			'post' => $data,
		) );
		return $post;
	}
}
