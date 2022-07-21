<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\Admin\TermEditViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\CategoryTermEditViewModelInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;

class CategoryTermEditViewModel extends TermEditViewModel
	implements CategoryTermEditViewModelInterface
{
	public function __construct(
		TcaSettingsRepositoryInterface $tca_settings_repository,
		CategoryTermRepositoryInterface $term_repository
	) {
		parent::__construct( $tca_settings_repository, $term_repository );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_view_props( array $data = array() ): array {
		if ( !isset( $data['term'] ) ) {
			return array();
		}
		$term = $data['term'];
		$term = $term->to_array();
		$props = array_merge( parent::get_view_props( $data ), array(
			'meta' => $term,
		) );
		return $props;
	}
}
