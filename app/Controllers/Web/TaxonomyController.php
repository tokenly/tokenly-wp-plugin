<?php

namespace Tokenly\Wp\Controllers\Web;

use Tokenly\Wp\Interfaces\Controllers\Web\TaxonomyControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TaxonomyEditViewModelInterface;

/**
 * Serves the taxonomy views
 */
class TaxonomyController implements TaxonomyControllerInterface {
	protected $taxonomy_edit_view_model;

	public function __construct(
		TaxonomyEditViewModelInterface $taxonomy_edit_view_model
	) {
		$this->taxonomy_edit_view_model = $taxonomy_edit_view_model;
	}
	
	/**
	 * Displays a section on taxonomy term edit screen.
	 */
	public function edit() {
		error_log(123);
		$view_data = $this->taxonomy_edit_view_model->prepare();
		return array(
			'template' => 'Dynamic.twig',
			'view'     => 'taxonomy-edit',
			'data'     => $view_data,
		);
	}
}
