<?php

namespace Tokenly\Wp\Models\Token\Access;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\Access\RuleCheckResultInterface;

class RuleCheckResult extends Model implements RuleCheckResultInterface {
	/**
	 * Hash based on the attributes of the rule.
	 * @var string
	 */
	protected ?string $hash = '';
	/**
	 * Check result.
	 * @var bool 
	 */
	protected ?bool $status = false;
	/**
	 * @inheritDoc
	 */

	public function get_hash(): ?string {
		return $this->hash ?? null;
	}

	public function set_hash( ?string $value ): void {
		$this->hash = $value;
	}

	public function get_status(): ?string {
		return $this->status ?? null;
	}

	public function set_status( ?string $value ): void {
		$this->status = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		return array(
			'hash'   => $this->get_hash(),
			'status' => $this->get_status(),
		);
	}

	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'hash',
			'status',
		) );
	}
}
