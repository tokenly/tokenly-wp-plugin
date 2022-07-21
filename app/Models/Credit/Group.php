<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupWhitelistInterface;

class Group extends Model implements GroupInterface {
	public ?string $name = null;
	public ?string $uuid = null;
	public ?bool $active = null;
	public ?array $app_whitelist = null;
	public ?string $created_at = null;
	public ?string $updated_at = null;

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
			'name'          => $this->name,
			'uuid'          => $this->uuid,
			'active'        => $this->active,
			'app_whitelist' => $this->app_whitelist,
			'created_at'    => $this->created_at,
			'updated_at'    => $this->updated_at,
		);
		return $array;
	}

	/**
	 * Checks if the group is allowed for this integration
	 * @param string $client_id Client ID
	 * @return bool
	 */
	public function has_valid_client_id( string $client_id ): bool {
		return ( in_array( $client_id, $this->app_whitelist ) );
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
