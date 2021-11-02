<?php

namespace Tokenly\Wp\Repositories;

use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\Wp\Repositories\SettingsRepository;

/**
 * Manages sources for promise type transactions
 */
class SourceRepository {
	public $client;
	
	public function __construct(
		TokenpassAPI $client,
		SettingsRepository $settings_repository
	) {
		$this->client = $client;
		$this->settings_repository = $settings_repository;
	}

	public function show( $address ) {
		$sources = $this->index();
		$source = $sources[ $address ] ?? null;
		return $source;
	}

	public function index() {
		$sources = $this->client->getProvisionalSourceList();
		return $sources;
	}
	
	public function store( $source ) {
		$settings = $this->settings_repository->show();
		$client_id = $settings['client_id'] ?? null;
		$hash = hash( 'sha256', $client_id );
		$address = $source['address'] ?? null;
		$type = $source['type'] ?? null;
		$proof =  $address . '_' . $hash;
		$assets = $source['assets'] ?? null;
		$result = $this->client->registerProvisionalSource( $address, $type, $proof, $assets );
		return $result;
	}

	public function update( $address, $params ) {
		return $this->store( $params );
	}

	public function destroy( $address ) {
		$this->client->deleteProvisionalSource( $address );
	}
}
