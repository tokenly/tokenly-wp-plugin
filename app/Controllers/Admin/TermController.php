<?php

namespace Tokenly\Wp\Controllers\Admin;

use Tokenly\Wp\Interfaces\Controllers\Admin\TermControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TermEditViewModelInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;

/**
 * Serves the admin Connection view
 */
class TermController implements TermControllerInterface {
	protected TermEditViewModelInterface $term_edit_view_model;

	public function __construct(
		TermEditViewModelInterface $term_edit_view_model
	) {
		$this->term_edit_view_model = $term_edit_view_model;
	}

	public function edit( TermInterface $term ): array {
		$input_data = array(
			'term' => $term,
		);
		$view_data = $this->term_edit_view_model->prepare( $input_data );
		return array(
			'view' => 'term-edit',
			'data' => $view_data,
		);
	}
}
