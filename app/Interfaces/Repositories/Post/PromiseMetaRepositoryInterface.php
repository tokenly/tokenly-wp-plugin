<?php

namespace Tokenly\Wp\Interfaces\Repositories\Post;

interface PromiseMetaRepositoryInterface {
	public function index( array $params = array() );
	public function show(  array $params = array() );
	public function update( array $params = array() );
}
