<?php

namespace Tokenly\Wp\ViewModels\Admin;

use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

class WhitelistViewModel {
	public $whitelist;
	
	public function __construct(
		WhitelistSettingsInterface $whitelist
	) {
		$this->whitelist = $whitelist;
	}
	
	public function prepare( array $data = array() ) {
		$whitelist = $this->whitelist->to_array();
		return array(
			'whitelist' => $whitelist,
		);
	}
}
