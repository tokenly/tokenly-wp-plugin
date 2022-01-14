<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\WhitelistEditViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

class WhitelistEditViewModel extends DynamicViewModel implements WhitelistEditViewModelInterface {
	protected $whitelist;
	
	public function __construct(
		WhitelistSettingsInterface $whitelist
	) {
		$this->whitelist = $whitelist;
	}
	
	protected function get_view_props( array $data = array() ) {
		$whitelist = $this->whitelist->to_array();
		return array(
			'whitelist' => $whitelist,
		);
	}
}
