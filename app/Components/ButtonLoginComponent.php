<?php

namespace Tokenly\Wp\Components;

use Tokenly\Wp\Routes\ApiRouter;

class ButtonLoginComponent {
	public $url;
	public $api_router;
	
	public function __construct() {
		$this->api_router = new ApiRouter();
		$this->url = $this->api_router->get_route_url( 'authorize' );
	}

	public function render() {
		$html = "
			<div class='tokenpass-login-container'>
				<a href='{$this->url}' class='button tokenpass-login'>Login with Tokenpass</a>
			</div>
		";
		return $html;
	}
}