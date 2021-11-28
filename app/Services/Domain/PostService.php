<?php

namespace Tokenly\Wp\Services\Domain;

use Tokenly\Wp\Services\Domain\DomainService;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;

class PostService extends DomainService implements PostServiceInterface {
	protected $meta_repository;
	protected $post_repository;
	protected $tca_rule_collection_factory;
	protected $tca_settings;

	public function __construct(
		MetaRepositoryInterface $meta_repository,
		PostRepositoryInterface $post_repository,
		TcaRuleCollectionFactoryInterface $tca_rule_collection_factory,
		TcaSettingsInterface $tca_settings,
		TcaServiceInterface $tca_service
	) {
		$this->meta_repository = $meta_repository;
		$this->post_repository = $post_repository;
		$this->tca_rule_collection_factory = $tca_rule_collection_factory;
		$this->tca_settings = $tca_settings;
		$this->tca_service = $tca_service;
	}
	
	public function show( array $params = array() ) {
		$post = $this->post_repository->show( $params );
		return $post;
	}

	public function update( int $post_id, $params = array() ) {
		$update_params = array();
		if ( isset( $params['tca_rules'] ) ) {
			$update_params['tca_rules'] = $params['tca_rules'];
		}
		$post = $this->meta_repository->update( $post_id, $update_params );
		return $post;
	}

	public function get_tca_rules( int $post_id ) {
		$rules = $this->meta_repository->show( $post_id, 'tca_rules' ) ?? array();
		if ( empty( $rules ) ) {
			$rules = array();
		}
		$rules = $this->tca_rule_collection_factory->create( $rules );
		return $rules;
	}

	public function set_tca_rules( int $post_id, TcaRuleCollectionInterface $rules ) {
		$rules = $rules->to_array();
		$this->meta_repository->update( 'tca_rules', $rules );
	}

	public function can_access_post( int $post_id, int $user_id ) {
		$post_type = get_post_type( $post_id );
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type( $post_type );
		if ( $tca_enabled === false ) {
			return true;
		}
		$tca_rules = $this->get_tca_rules( $post_id );
		if ( count( $tca_rules ) == 0 ) {
			return true;
		}
		$tca_allowed = $this->tca_service->check_token_access_user( $user_id, $tca_rules ) ?? false;
		return $tca_allowed;
	}
}



