<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\SettingsRepository;

class SourceRepository {
	public $client;
	
	public function __construct(
		TokenpassAPI $client,
		SettingsRepository $settings_repository
	) {
		$this->client = $client;
		$this->settings_repository = $settings_repository;
	}
	public function index() {
		return $this->client->getProvisionalSourceList();
	}
	
	public function store( $source ) {
		$settings = $this->settings_repository->show();
		$client_id = $settings['client_id'] ?? null;
		$hash = hash( 'sha256', $client_id );
		$address = $source['address'] ?? null;
		$proof =  $address . '_' . $hash;
		$result = $this->client->registerProvisionalSource(
			$source['address'] ?? null,
			$chain = 'bitcoin',
			$proof = $proof,
			$source['assets'] ?? null,
		);
		return $result;
	}
}
