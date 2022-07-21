<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface;

use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface;

class Account extends Model implements AccountInterface {
	public ?string $name = null;
	public ?string $uuid = null;
	public ?float $balance = null;
	public ?array $oauth_user = null;
	public ?string $created_at = null;
	public ?string $updated_at = null;
	public ?string $group_id = null;
	public ?GroupInterface $group = null;

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'name'       => $this->name,
			'uuid'       => $this->uuid,
			'balance'    => $this->balance,
			'oauth_user' => $this->oauth_user,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'group_id'   => $this->group_id,
		);
		if ( $this->group ) {
			$array['group'] = $this->group->to_array();
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
