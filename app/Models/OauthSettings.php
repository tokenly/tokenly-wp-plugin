<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;

class OauthSettings extends Model implements OauthSettingsInterface {
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
				'use_single_sign_on',
				'redirect_url',
				'allow_no_email',
				'allow_unconfirmed_email',
			)
		);
		parent::__construct( $data );
	}
}
