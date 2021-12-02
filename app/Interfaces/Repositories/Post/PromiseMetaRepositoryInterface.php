<?php

namespace Tokenly\Wp\Interfaces\Repositories\Post;

use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;

interface PromiseMetaRepositoryInterface {
	public function index( array $params = array() );
	public function show(  array $params = array() );
	public function update( PromiseMetaInterface $promise_meta, array $params = array() );
	public function destroy( PromiseMetaInterface $post );
}
