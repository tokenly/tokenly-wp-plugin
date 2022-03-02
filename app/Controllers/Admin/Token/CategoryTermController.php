<?php

namespace Tokenly\Wp\Controllers\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\CategoryTermControllerInterface;
use Tokenly\Wp\Controllers\Admin\TermController;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\CategoryTermEditViewModelInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;

/**
 * Serves the admin address views
 */
class CategoryTermController extends TermController implements CategoryTermControllerInterface {
	protected string $fallback_image;
	protected CategoryTermEditViewModelInterface $edit_view_model;
	protected CategoryTermRepositoryInterface $category_term_repository;

	public function __construct(
		string $fallback_image,
		CategoryTermEditViewModelInterface $edit_view_model,
		CategoryTermRepositoryInterface $category_term_repository
	) {
		$this->fallback_image = $fallback_image;
		$this->edit_view_model = $edit_view_model;
		$this->category_term_repository = $category_term_repository;
	}

	public function edit( TermInterface $term ): array {
		$input_data = array(
			'term' => $term,
		);
		$view_data = $this->edit_view_model->prepare( $input_data );
		return array(
			'view' => 'token-category-term-edit',
			'data' => $view_data,
		);
	}

	public function show( TermInterface $term ): array {
		$term = $term->to_array();
		$view_data = array(
			'fallback_image' => $this->fallback_image,
			'term'           => $term,
		);
		return array(
			'template' => 'TokenCategoryTerm.twig',
			'data'     => $view_data,
		);
	}
}
