<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class OauthSettings extends Settings implements OauthSettingsInterface {
	protected ?bool $use_single_sign_on = false;
	protected ?string $success_url = '/tokenly/user/me/';
	protected ?bool $allow_no_email = false;
	protected ?bool $allow_unconfirmed_email = false;

	public function get_use_single_sign_on(): ?bool {
		return $this->use_single_sign_on ?? null;
	}

	public function set_use_single_sign_on( ?bool $value ): void {
		$this->use_single_sign_on = $value;
	}

	public function get_success_url(): ?string {
		return $this->success_url ?? null;
	}

	public function set_success_url( ?string $value ): void {
		$this->success_url = $value;
	}

	public function get_allow_no_email(): ?string {
		return $this->allow_no_email ?? null;
	}

	public function set_allow_no_email( ?string $value ) {
		$this->allow_no_email = $value;
	}

	public function get_allow_unconfirmed_email(): ?string {
		return $this->allow_unconfirmed_email ?? null;
	}

	public function set_allow_unconfirmed_email( ?string $value ): void {
		$this->allow_unconfirmed_email = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'use_single_sign_on'      => $this->get_use_single_sign_on(),
			'success_url'             => $this->get_success_url(),
			'allow_no_email'          => $this->get_allow_no_email(),
			'allow_unconfirmed_email' => $this->get_allow_unconfirmed_email(),
		);
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'use_single_sign_on',
			'success_url',
			'allow_no_email',
			'allow_unconfirmed_email',
		) );
	}
}
