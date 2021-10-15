<?php

namespace Tokenly\Wp\Admin\Tokenpass;

use Tokenly\Wp\Admin\AdminPage;
use Tokenly\Wp\Routes\ApiRouter;

class TokenpassSettingsPage extends AdminPage {
	public $settings_group = 'tokenpass_settings_group';
	public $api_router;

	public function __construct( $route_args ) {
		parent::__construct( $route_args );
		$this->api_router = new ApiRouter();
	}

	public function register_settings() {
		register_setting(
			$this->settings_group,
			'tokenpass_settings',
			array( $this, 'sanitize_settings' )
		);
		add_settings_section(
			'tokenpass_settings_section',
			'Settings',
			array( $this, 'render_section_info' ),
			$this->page_slug
		);
		add_settings_field(
			'client_id',
			'Client Id',
			array( $this, 'render_client_id_field' ),
			$this->page_slug,
			'tokenpass_settings_section'
		);
		add_settings_field(
			'client_secret',
			'Client Secret',
			array( $this, 'render_client_secret_field' ),
			$this->page_slug,
			'tokenpass_settings_section'
		);
	}

	public function sanitize_settings( $input ) {
		$sanitary_values = array();
		if ( isset( $input['client_id'] ) ) {
			$sanitary_values['client_id'] = sanitize_text_field( $input['client_id'] );
		}

		if ( isset( $input['client_secret'] ) ) {
			$sanitary_values['client_secret'] = sanitize_text_field( $input['client_secret'] );
		}

		return $sanitary_values;
	}

	public function render_settings_errors() {
		ob_start();
			settings_errors();
		return ob_get_clean();
	}

	public function render_section_info() {
		$app_homepage_url = 'https://';
		$app_homepage_url .= $_SERVER['HTTP_HOST'] . '/tokenly';
		$client_auth_url = $this->api_router->get_route_url( 'authorize-callback' );
		echo "
			<div class='tk_documentation'>
				<h3>How to Setup</h3>
				<ul class='tk_steps'>
					<li>1. Create App on <a href='https://tokenpass.tokenly.com/auth/apps'>Tokenpass Developers</a></li>
					<li>2. Use below details to create App </a></li>
				</ul>
				<div class='tk_app_details'>
					<h3>Register Client Application</h3>
					<span> <b>CLIENT NAME: </b> Random Input </span><br>
					<span> <b>APP HOMEPAGE URL: </b> {$app_homepage_url} </span><br>
					<span> <b>CLIENT AUTHORIZATION REDIRECT URL: </b> {$client_auth_url} </span>
				</div>
			</div>
		";
	}

	public function render_client_id_field() {
		$value = isset( $this->settings['client_id'] ) ? esc_attr( $this->settings['client_id'] ) : '';
		echo "
			<input class='regular-text' type='text' name='tokenpass_settings[client_id]' id='client_id' value='{$value}'>
		";
	}

	public function render_client_secret_field() {
		$value = isset( $this->settings['client_secret'] ) ? esc_attr( $this->settings['client_secret'] ) : '';
		echo "
			<input class='regular-text' type='text' name='tokenpass_settings[client_secret]' id='client_secret' value='{$value}'>
			
		";
	}

	public function render_fields() {
		ob_start();
			settings_fields( $this->settings_group );
			do_settings_sections( $this->page_slug );
			submit_button();
		return ob_get_clean();
	}

	public function page_callback() {
		$this->settings = get_option( 'tokenpass_settings' );
		$html_errors = $this->render_settings_errors();
		$html_fields = $this->render_fields();
		$html = "
			<div class='wrap'>
				<h2>Tokenpass</h2>
				{$html_errors}
				<hr>
				<hr>
				<form method='post' action='options.php'>
					{$html_fields}
				</form>
			</div>
		";
		echo $html;
	}
}