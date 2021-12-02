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
		$whitelist = $this->whitelist->to_array();
		return $whitelist;
	}

	public function update( $request ) {
		$params = $request->get_params();
		if ( isset( $params['items'] ) ) {
			$params['items'] = json_decode( $params['items'], true );
		}
		$this->whitelist->update( $params );
		return array(
			'status' => 'Whitelist was updated successfully.',
		);
	}
}
