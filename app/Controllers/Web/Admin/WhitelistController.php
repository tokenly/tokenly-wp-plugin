<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\WhitelistView;
use Tokenly\Wp\Controllers\Web\WebController;

class WhitelistController extends WebController {
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
