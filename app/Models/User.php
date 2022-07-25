<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\UserInterface;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class User extends Model implements UserInterface {
	public ?\WP_User $user = null;
	public ?OauthUserInterface $oauth_user = null;
	public ?string $oauth_token = null;
	public ?string $uuid = null;
	public ?bool $can_connect = false;

	/**
	 * @inheritDoc
	 */
	public function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'user',
			'oauth_token',
			'uuid',
			'can_connect',
		) );
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->user, $method ), $args );
	}

	public function __get( $key ) {
		return $this->user->$key;
	}

	public function __set( $key, $value ) {
		return $this->user->$key = $value;
	}
	
	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array();
		$array_parent = parent::to_array();
		$array_user = array();
		if ( $this->user ) {
			$array_user = array_merge( $array_user, array(
				'id'           => $this->user->ID,
				'name'         => $this->user->user_login,
				'name_display' => $this->user->display_name,
				'description'  => $this->user->description,
				'avatar'       => get_avatar_url( $this->user->ID, array(
					'size' => 180,
				) ),
				'can_connect'  => $this->can_connect,
			) );
		}
		if ( $this->oauth_user ) {
			$array['oauth_user'] = $this->oauth_user->to_array();
		}
		$array = array_merge( $array, $array_parent, $array_user );
		return $array;
	}
}
