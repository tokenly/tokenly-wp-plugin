<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;

class IntegrationSettings extends Settings implements IntegrationSettingsInterface {
	protected ?string $client_id = null;
	protected ?string $client_secret = null;
	protected ?bool $settings_updated = null;
	protected ?bool $can_connect = null;

	public function get_client_id(): ?string {
		return $this->client_id ?? null;
	}

	public function set_client_id( ?string $value ): void {
		$this->client_id = $value;
	}

	public function get_client_secret(): ? string {
		return $this->client_secret ?? null;
	}

	public function set_client_secret( ?string $value ): void {
		$this->client_secret = $value;
	}

	public function get_settings_updated(): ?bool {
		return $this->settings_updated ?? null;
	}

	public function set_settings_updated( ?bool $value ): void {
		$this->settings_updated = $value;
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
	public function from_array( array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'client_id'        => $this->get_client_id(),
			'client_secret'    => $this->get_client_secret(),
			'settings_updated' => $this->get_settings_updated(),
			'can_connect'      => $this->get_can_connect(),
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
