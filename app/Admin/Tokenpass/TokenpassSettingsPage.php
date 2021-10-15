<?php

namespace Tokenly\Wp\Admin\Tokenpass;

use Tokenly\Wp\Admin\AdminPage;
use Tokenly\Wp\Routes\ApiRouter;

class TokenpassSettingsPage extends AdminPage {
	public $api_router;

	public function __construct( $route_args ) {
		parent::__construct( $route_args );
		$this->api_router = new ApiRouter();
	}

	public function page_callback() {
		$app_homepage_url = 'https://';
		$app_homepage_url .= $_SERVER['HTTP_HOST'] . '/tokenly';
		$client_auth_url = $this->api_router->get_route_url( 'authorize-callback' );
		$html = "
			<script>
				const appHomepageUrl = '{$app_homepage_url}';
				const clientAuthUrl = '{$client_auth_url}';
			</script>
			<div id='tokenpass-settings-page-content'></div>
		";
		echo $html;
	}
}
