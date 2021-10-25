<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Repositories\WhitelistRepository;

class WhitelistController {
	public function __construct(
		WhitelistRepository $whitelist_repository
	) {
		$this->whitelist_repository = $whitelist_repository;
	}
	
	public function show( $request ) {
		return $this->whitelist_repository->show();
	}

	public function update( $request ) {
		$settings = $request['settings'] ?? null;
		if ( !$settings ) {
			return array(
				'status' => 'Error. Whitelist was not updated.',
			);
		}
		$this->whitelist_repository->update( $settings );
		return array(
			'status' => 'Whitelist was updated successfully.',
		);
	}
}
