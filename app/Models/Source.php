<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;

class Source extends Model implements SourceInterface {
	public $address;
	public $address_data;
	public $assets;
	public $type;
	protected $fillable = array(
		'address',
		'address_data',
		'assets',
		'type'
	);

	public function __construct(
		SourceServiceInterface $domain_service,
		array $data = array()
	) {
		$this->address = $source_data['address'] ?? null;
		$this->assets = $source_data['assets'] ?? null;
		$this->type = $source_data['type'] ?? null;
		$this->source_service = $domain_service;
		parent::__construct( $data );
	}

	/**
	 * Destroys the source
	 * @return void
	 */
	public function destroy() {
		$this->domain_service->destroy( $this->address );
	}
}
