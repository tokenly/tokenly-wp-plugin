<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;

class Group extends Model implements GroupInterface {
	protected ?string $name = null;
	protected ?string $uuid = null;
	protected ?bool $active = null;
	protected ?array $app_whitelist = null;
	protected ?string $created_at = null;
	protected ?string $updated_at = null;

	public function get_name(): ?string {
		return $this->name ?? null;
	}

	public function set_name( ?string $value ): void {
		$this->name = $value;
	}

	public function get_uuid(): ?string {
		return $this->uuid ?? null;
	}

	public function set_uuid( ?string $value ): void {
		$this->uuid = $value;
	}

	public function get_active(): ?bool {
		return $this->active ?? null;
	}

	public function set_active( ?bool $value ): void {
		$this->active = $value;
	}

	public function get_app_whitelist(): ?array {
		return $this->app_whitelist ?? null;
	}

	public function set_app_whitelist( ?array $value ): void {
		$this->app_whitelist = $value;
	}

	public function get_created_at(): ?string {
		return $this->created_at ?? null;
	}

	public function set_created_at( ?string $value ): void {
		$this->created_at = $value;
	}

	public function get_updated_at(): ?string {
		return $this->updated_at ?? null;
	}

	public function set_updated_at( ?string $value ): void {
		$this->updated_at = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( ?array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'name'          => $this->get_name(),
			'uuid'          => $this->get_uuid(),
			'active'        => $this->get_active(),
			'app_whitelist' => $this->get_app_whitelist(),
			'created_at'    => $this->get_created_at(),
			'updated_at'    => $this->get_updated_at(),
		);
		return $array;
	}

	/**
	 * Checks if the group is allowed for this integration
	 * @param string $client_id Client ID
	 * @return bool
	 */
	public function has_valid_client_id( string $client_id ): bool {
		return ( in_array( $client_id, $this->get_app_whitelist() ) );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'name',
			'uuid',
			'active',
			'app_whitelist',
			'created_at',
			'updated_at',
		) );
	}
}
