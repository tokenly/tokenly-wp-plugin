<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\WhitelistViewModelInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

class WhitelistViewModel extends ViewModel implements WhitelistViewModelInterface {
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
