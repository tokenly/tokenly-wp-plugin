<?php

namespace Tokenly\Wp\Services;

use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;

/**
 * Handles version changes
 */
class TcaService implements TcaServiceInterface {
	protected $post_service;

	public function __construct(
		PostServiceInterface $post_service
	) {
		$this->post_service = $post_service;
	}
}
