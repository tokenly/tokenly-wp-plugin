<?php

namespace Tokenly\Wp\Repositories\Post;

use Tokenly\Wp\Repositories\General\MetaRepository;

class TokenMetaRepository {
	public $client;
	public $meta_repository;
	
	public function __construct(
		MetaRepository $meta_repository
	) {
		$this->meta_repository = $meta_repository;
	}
	
	public function show( $post_id ) {
		return $this->meta_repository->index( $post_id, array(
			'asset',
		) );
	}
	
	public function update( $post_id, $settings ) {
		$this->meta_repository->update( $post_id, array(
			'asset' => $settings['asset'] ?? null,
		) );
	}
}
