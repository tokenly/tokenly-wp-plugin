<?php

namespace Tokenly\Wp\Controllers\Api;

use Tokenly\Wp\Interfaces\Controllers\Api\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;

class WhitelistController implements WhitelistControllerInterface {
	public function __construct(
		WhitelistInterface $whitelist
	) {
		$this->whitelist = $whitelist;
	}

	public function show( $request ) {
		return $this->whitelist->to_array();
	}

	public function update( $request ) {
		$params = $request->get_params();
		$this->whitelist->update( $params );
		return array(
			'status' => 'Whitelist was updated successfully.',
		);
	}
}
