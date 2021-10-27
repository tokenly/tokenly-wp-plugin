<?php

namespace Tokenly\Wp\Repositories;

class TokenMetaRepository {
	public $client;
	
	public function __construct() {
		//
	}
	public function index( $index_options ) {
		$assets = $index_options['assets'] ?? null;
		$posts = array();
		if ( $assets ) {
			foreach ( $assets as $asset ) {
				$posts[] = get_page_by_title( $asset, OBJECT, 'token-meta' );
			}
		}
		return $posts;
	}

	public function show( $show_options ) {
		$name = $show_options['name'] ?? null;
		$post;
		if ( $name ) {
			$post = get_page_by_title( $name, OBJECT, 'token-meta' );
		}
		return $post;
	}
	
	public function store( $source ) {
		$settings = $this->settings_repository->show();
		$client_id = $settings['client_id'] ?? null;
		$hash = hash( 'sha256', $client_id );
		$address = $source['address'] ?? null;
		$proof =  $address . '_' . $hash;
		$result = $this->client->registerProvisionalSource(
			$source['address'] ?? null,
			$chain = 'bitcoin',
			$proof = $proof,
			$source['assets'] ?? null,
		);
		return $result;
	}
}
