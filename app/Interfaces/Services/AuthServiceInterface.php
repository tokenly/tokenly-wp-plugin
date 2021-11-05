<?php

namespace Tokenly\Wp\Interfaces\Services;

interface AuthServiceInterface {
	public function set_state( $state );
	public function delete_state();
	public function validate_state( $state );
	public function can_social_login( $tokenpass_user );
	public function find_existing_user( $tokenpass_user );
	public function create_user_from_tokenpass_user( $tokenpass_user );
	public function authorize_callback( $state, $code );
	public function embed_tokenpass_login();
	public function authorize_begin();
	public function is_connected( $id );
	public function disconnect();
	public function get_tokenpass_login_url();
}
