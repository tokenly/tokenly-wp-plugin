<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Views\Admin\WhitelistView;

/**
 * Serves the admin Whitelist view
 */
class WhitelistController implements WhitelistControllerInterface {
	public $whitelist_view;

	public function __construct( WhitelistView $whitelist_view ) {
		$this->whitelist_view = $whitelist_view;
	}

	public function show() {
		$render = $this->whitelist_view->render( array(
			//
		) );
		echo $render;
	}
}
