<?php

/**
 * Implements settings pages for admin
 */

namespace Tokenly\Wp\Admin;

class SettingsService {
	private $tk_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function register_page() {
		add_options_page(
			__( 'Tokenpass Settings', 'tokenpass' ),
			__( 'Tokenpass', 'tokenpass' ),
			'manage_options',
			'tk-settings',
			array( $this, 'render_settings_page' ),
		);
	}

	public function render_fields() {
		ob_start();
		settings_fields( 'tk_settings_option_group' );
		do_settings_sections( 'tk-settings-admin' );
		submit_button();
		return ob_get_clean();
	}

	public function render_settings_page() {
		$this->tk_settings_options = get_option( 'tokenpass_settings' );
		$app_homepage_url = 'https://';
		$app_homepage_url .= $_SERVER['HTTP_HOST'] . '/tokenly';
		$client_auth_url = $app_homepage_url . '/wp-content/plugins/tokenpass/account/authorize/callback.php';
		ob_start();
		settings_errors();
		$html_settings_errors = ob_get_clean();
		$html_fields = $this->render_fields();
		$html = "
			<div class='wrap'>
				<h2>Tokenpass</h2>
				<p></p>
				{$html_settings_errors}
				<hr>
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
				<br>
				<hr>
				<form method='post' action='options.php'>
					{$html_fields}
				</form>
			</div>
		";
		echo $html;
	}

	public function tk_inventory_dash_html() {
		load_template_part_tk( 'templates', 'tokenpass-dashboard' );
	}

	public function register_settings() {
		register_setting(
			'tokenpass_settings_group',
			'tokenpass_settings',
			array( $this, 'sanitize_settings' )
		);
		add_settings_section(
			'tokenpass_settings_section',
			'Settings',
			array( $this, 'render_section_info' ),
			'tk-settings-admin'
		);
		add_settings_field(
			'client_id',
			'Client Id',
			array( $this, 'render_client_id_field' ),
			'tk-settings-admin',
			'tokenpass_settings_section'
		);
		add_settings_field(
			'client_secret',
			'Client Secret',
			array( $this, 'render_client_secret_field' ),
			'tk-settings-admin',
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

	public function render_section_info() {
		//
	}

	public function render_client_id_field() {
		$value = isset( $this->tk_settings_options['client_id'] ) ? esc_attr( $this->tk_settings_options['client_id'] ) : '';
		echo "
			<input class='regular-text' type='text' name='tk_settings_option_name[client_id]' id='client_id' value='{$value}'>
		";
	}

	public function render_client_secret_field() {
		$value = isset( $this->tk_settings_options['client_secret'] ) ? esc_attr( $this->tk_settings_options['client_secret'] ) : '';
		echo "
			<input class='regular-text' type='text' name='tk_settings_option_name[client_secret]' id='client_secret' value='{$value}'>
			
		";
	}
}
