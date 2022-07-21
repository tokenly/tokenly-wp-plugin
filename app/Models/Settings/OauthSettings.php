<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class OauthSettings extends Settings implements OauthSettingsInterface {
	public ?bool $use_single_sign_on = false;
	public ?bool $allow_no_email = false;
	public ?bool $allow_unconfirmed_email = false;
	public ?string $success_url = '/tokenly/user/me/';

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
			'use_single_sign_on'      => $this->use_single_sign_on,
			'success_url'             => $this->success_url,
			'allow_no_email'          => $this->allow_no_email,
			'allow_unconfirmed_email' => $this->allow_unconfirmed_email,
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
