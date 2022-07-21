<?php

namespace Tokenly\Wp\Models\Token\Access;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\Access\RuleCheckResultInterface;

class RuleCheckResult extends Model implements RuleCheckResultInterface {
	/**
	 * Hash based on the attributes of the rule.
	 * @var string
	 */
	public ?string $hash = '';
	/**
	 * Check result.
	 * @var bool 
	 */
	public ?bool $status = false;
	/**
	 * @inheritDoc
	 */

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		return array(
			'hash'   => $this->hash,
			'status' => $this->status,
		);
	}

	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'hash',
			'status',
		) );
	}
}
