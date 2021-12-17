<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\TermControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TermEditViewModelInterface;

/**
 * Serves the term views
 */
class TermController implements TermControllerInterface {
	protected $term_edit_view_model;

	public function __construct(
		TermEditViewModelInterface $term_edit_view_model
	) {
		$this->term_edit_view_model = $term_edit_view_model;
	}
	
	/**
	 * Displays a section on taxonomy term edit screen.
	 */
	public function edit( \WP_Term $term ) {
		$input_data = array(
			'term' => $term,
		);
		$view_data = $this->term_edit_view_model->prepare( $input_data );
		return array(
			'template' => 'Dynamic.twig',
			'view'     => 'taxonomy-edit',
			'data'     => $view_data,
		);
	}
}
