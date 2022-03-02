<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

class Account extends Model implements AccountInterface {
	protected ?string $name = null;
	protected ?string $uuid = null;
	protected ?float $balance = null;
	protected ?array $oauth_user = null;
	protected ?string $created_at = null;
	protected ?string $updated_at = null;
	protected ?string $group_id = null;
	protected ?GroupInterface $group = null;

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

	public function get_balance(): ?float {
		return $this->balance ?? null;
	}

	public function set_balance( ?float $value ): void {
		$this->balance = $value;
	}

	public function get_oauth_user(): ?array {
		return $this->oauth_user ?? null;
	}

	public function set_oauth_user( ?array $value ): void {
		$this->oauth_user = $value;
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

	public function get_group_id(): ?string {
		return $this->group_id ?? null;
	}

	public function set_group_id( ?string $value ): void {
		$this->group_id = $value;
	}

	public function get_group(): ?GroupInterface {
		return $this->group ?? null;
	}

	public function set_group( ?GroupInterface $value ): void {
		$this->group = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'name'       => $this->get_name(),
			'uuid'       => $this->get_uuid(),
			'balance'    => $this->get_balance(),
			'oauth_user' => $this->get_oauth_user(),
			'created_at' => $this->get_created_at(),
			'updated_at' => $this->get_updated_at(),
			'group_id'   => $this->get_group_id(),
		);
		if ( $this->get_group() ) {
			$array['group'] = $this->get_group()->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'name',
			'uuid',
			'balance',
			'oauth_user',
			'created_at',
			'updated_at',
			'group_id',
		) );
	}
}
