<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;

class WhitelistController implements WhitelistControllerInterface {
	public function __construct(
		WhitelistRepositoryInterface $whitelist_repository
	) {
		$this->whitelist_repository = $whitelist_repository;
	}

	public function show( $request ) {
		return $this->whitelist_repository->show();
	}

	public function update( $request ) {
		$params = $request->get_params();
		$this->whitelist_repository->update( $params );
		return array(
			'status' => 'Whitelist was updated successfully.',
		);
	}
}
