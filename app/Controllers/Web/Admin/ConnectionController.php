<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Views\Admin\ConnectionView;
use Tokenly\Wp\Controllers\Web\WebController;

class ConnectionController extends WebController {
	public $connection_view;

	public function __construct( ConnectionView $connection_view ) {
		$this->connection_view = $connection_view;
	}

	public function show() {
		$render = $this->connection_view->render( array(
			//
		) );
		echo $render;
	}
}
