<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Views\Admin\WhitelistView;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;

/**
 * Serves the admin Whitelist view
 */
class WhitelistController implements WhitelistControllerInterface {
	public $whitelist_view;
	public $whitelist;

	public function __construct(
		WhitelistView $whitelist_view,
		WhitelistSettingsInterface $whitelist
	) {
		$this->whitelist_view = $whitelist_view;
		$this->whitelist = $whitelist;
	}

	public function show() {
		$whitelist = $this->whitelist->to_array();
		$render = $this->whitelist_view->render( array(
			'whitelist' => $whitelist,
		) );
		return $render;
	}
}
