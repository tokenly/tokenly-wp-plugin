<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Services\Domain\DomainServiceInterface;

interface PostServiceInterface extends DomainServiceInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function complete( \WP_Post $post );
	public function complete_collection( array $posts );
}
