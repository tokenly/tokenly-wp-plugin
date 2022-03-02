<?php

namespace Tokenly\Wp\Interfaces\Repositories;

use Tokenly\Wp\Interfaces\Repositories\RepositoryInterface;

use Tokenly\Wp\Interfaces\Models\PostInterface;

interface PostRepositoryInterface extends RepositoryInterface {
	public function index( array $params = array() );
	public function show( array $params = array() );
	public function store( array $params );
	public function update( PostInterface $post, array $params = array() );
	public function destroy( PostInterface $post );
	public function complete( \WP_Post $post );
	public function complete_collection( array $posts );
}
