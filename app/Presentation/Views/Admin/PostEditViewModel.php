<?php

namespace Tokenly\Wp\Presentation\Views\Admin;

use Tokenly\Wp\Presentation\Views\DynamicViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PostEditViewModelInterface;

use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;

class PostEditViewModel extends DynamicViewModel
	implements PostEditViewModelInterface
{
	protected TcaSettingsInterface $tca_settings;
	protected TcaSettingsRepositoryInterface $tca_settings_repository;
	protected PostRepositoryInterface $post_repository;
	
	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		PostRepositoryInterface $post_repository
	) {
		$this->tca_settings_repository = $tca_settings_repository;
		$this->tca_settings = $this->tca_settings_repository->show();
		$this->post_repository = $post_repository;
	}
	
	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		$post = $data['post'];
		$tca_enabled = $this->tca_settings->is_enabled_for_post_type(
			$post->post_type
		);
		$tca_rules = array();
		if ( $post->tca_rules ) {
			$tca_rules = $post->tca_rules->to_array();
		}
		$props = array(
			'tca_enabled' => $tca_enabled,
			'tca_rules'   => $tca_rules,
			'post'        => $post->to_array(),
		);
		return $props;
	}
}
