<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TcaSettingsServiceInterface;

class TcaSettings extends Model implements TcaSettingsInterface {
	public $post_types = array();
	public $filter_menu_items = true;
	public $filter_post_results = true;
	protected $fillable = array(
		'post_types',
		'filter_menu_items',
		'filter_post_results',
	);
	
	public function __construct(
		TcaSettingsServiceInterface $domain_service,
		array $data = array()
	) {
		$this->domain_service = $domain_service;
		parent::__construct( $data );
	}

	public function is_enabled_for_post_type( string $post_type ) {
		return $this->post_types[ $post_type ] ?? false;
	}
}
