<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;

use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class Integration extends Model implements IntegrationInterface {
	protected ?IntegrationSettingsInterface $settings = null;
	protected ?bool $can_connect = false;

	public function get_can_connect(): ?bool {
		return $this->can_connect ?? null;
	}

	public function set_can_connect( ?bool $value ): void {
		$this->can_connect = $value;
	}

	public function get_settings(): ?IntegrationSettingsInterface {
		return $this->settings ?? null;
	}

	public function set_settings( ?IntegrationSettingsInterface $value ): void {
		$this->settings = $value;
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
			'can_connect' => $this->get_can_connect(),
		);
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'can_connect',
		) );
	}
}
