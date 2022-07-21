<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

class IntegrationSettings extends Settings implements IntegrationSettingsInterface {
	public ?string $client_id = null;
	public ?string $client_secret = null;
	public ?bool $settings_updated = null;
	public ?bool $can_connect = null;

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
			'client_id'        => $this->client_id,
			'client_secret'    => $this->client_secret,
			'settings_updated' => $this->settings_updated,
			'can_connect'      => $this->can_connect,
		);
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'client_id',
			'client_secret',
			'settings_updated',
			'can_connect',
		) );
	}
}
