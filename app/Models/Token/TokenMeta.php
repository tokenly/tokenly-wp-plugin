<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;

use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;

class TokenMeta extends Post implements TokenMetaInterface {
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
		TokenMetaRepositoryInterface $domain_repository,
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
	
	public function to_array() {
		$array = parent::to_array();
		$array['name'] = $this->post_title;
		$array['description'] = $this->post_excerpt;
		return $array;
	}
}
