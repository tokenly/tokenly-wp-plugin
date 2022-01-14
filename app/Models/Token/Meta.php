<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

class Meta extends Post implements MetaInterface {
	public $asset;
	public $extra;
	protected $fillable = array(
		'post',
		'asset',
		'extra',
	);

	public function __construct(
		//Parent dependencies
		TcaSettingsInterface $tca_settings,
		TermServiceInterface $term_service,
		//Parent dependencides - end
		MetaRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		parent::__construct(
			$domain_repository,
			$tca_settings,
			$term_service,
			$data
		);
	}

	/**
	 * Updates the model
	 * @param array $data New data
	 * @return object
	 */
	public function update( array $data = array() ) {
		if ( isset( $data['extra'] ) && is_array( $data['extra'] ) ) {
			$data['extra'] = array_filter( $data['extra'] );
		}
		return parent::update( $data );
	}
	
	public function to_array() {
		$array = parent::to_array();
		$array['name'] = $this->post_title;
		$array['description'] = $this->post_excerpt;
		return $array;
	}
}
