<?php

/**
 * WP_User decorator
 */

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\UserInterface;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

class User extends Model implements UserInterface {
	protected ?\WP_User $user;
	protected ?OauthUserInterface $oauth_user;
	protected ?string $oauth_token;
	protected ?string $uuid;
	protected ?bool $can_connect;

	public function get_user(): ?\WP_User {
		return $this->user ?? null;
	}

	public function set_user( ?\WP_User $value ): void {
		$this->user = $value;
	}

	public function get_oauth_user(): ?OauthUserInterface {
		return $this->oauth_user ?? null;
	}

	public function set_oauth_user( ?OauthUserInterface $value ): void {
		$this->oauth_user = $value;
	}

	public function get_oauth_token(): ?string {
		return $this->oauth_token ?? null;
	}

	public function set_oauth_token( ?string $value ): void {
		$this->oauth_token = $value;
	}

	public function get_uuid(): ?string {
		return $this->uuid ?? null;
	}

	public function set_uuid( ?string $value ): void {
		$this->uuid = $value;
	}

	public function get_can_connect(): ?bool {
		return $this->can_connect ?? null;
	}

	public function set_can_connect( ?bool $value ): void {
		$this->can_connect = $value;
	}

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
		return call_user_func_array( array( $this->get_user(), $method ), $args );
	}

	public function __get( $key ) {
		return $this->get_user()->$key;
	}

	public function __set( $key, $value ) {
		return $this->get_user()->$key = $value;
	}
	
	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array();
		$array_parent = parent::to_array();
		$array_user = array();
		if ( $this->get_user() ) {
			$array_user = array_merge( $array_user, array(
				'id'           => $this->get_user()->ID,
				'name'         => $this->get_user()->user_login,
				'name_display' => $this->get_user()->display_name,
				'description'  => $this->get_user()->description,
				'avatar'       => get_avatar_url( $this->get_user()->ID, array(
					'size' => 180,
				) ),
				'can_connect'  => $this->get_can_connect(),
			) );
		}
		if ( $this->get_oauth_user() ) {
			$array['oauth_user'] = $this->get_oauth_user()->to_array();
		}
		$array = array_merge( $array, $array_parent, $array_user );
		return $array;
	}
}
