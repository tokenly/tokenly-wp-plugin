<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\WhitelistEditViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

class WhitelistEditViewModel extends ViewModel implements WhitelistEditViewModelInterface {
	protected $whitelist;
	
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
