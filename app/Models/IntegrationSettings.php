<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class IntegrationSettings extends Model implements IntegrationSettingsInterface {
	public $client_id = '';
	public $client_secret = '';
	public $settings_updated = false;
	protected $option_repository;
	protected $fillable = array(
		'client_id',
		'client_secret',
		'settings_updated',
	);

	public function __construct(
		OptionRepositoryInterface $option_repository,
		array $data = array()
	) {
		$this->option_repository = $option_repository;
		$data = $this->option_repository->index( array(
				'client_id',
				'client_secret',
				'settings_updated',
			)
		);
		parent::__construct( $data );
	}

	public function save() {
		$this->settings_updated = true;
		$save_data = $this->to_array();
		$this->option_repository->update( $save_data );
	}
}
