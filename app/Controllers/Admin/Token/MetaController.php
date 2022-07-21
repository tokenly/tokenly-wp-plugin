<?php

namespace Tokenly\Wp\Controllers\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Admin\Token\MetaControllerInterface;
use Tokenly\Wp\Controllers\Admin\PostController;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\MetaEditViewModelInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;

/**
 * Serves the admin address views
 */
class MetaController extends PostController
	implements MetaControllerInterface
{
	protected MetaEditViewModelInterface $edit_view_model;
	protected MetaRepositoryInterface $meta_repository;
	protected CategoryTermRepositoryInterface $category_term_repository;

	public function __construct(
		MetaEditViewModelInterface $edit_view_model,
		MetaRepositoryInterface $meta_repository,
		CategoryTermRepositoryInterface $category_term_repository
	) {
		$this->edit_view_model = $edit_view_model;
		$this->meta_repository = $meta_repository;
		$this->category_term_repository = $category_term_repository;
	}
	
	public function edit( PostInterface $post ): array {
		$input_data = array(
			'post' => $post,
		);
		$view_data = $this->edit_view_model->prepare( $input_data );
		return array(
			'view' => 'token-meta-edit',
			'data' => $view_data,
		);
	}

	public function show( PostInterface $post ): array {
		$terms = $this->category_term_repository->index( array(
			'id' => $post->ID,
		) );
		if ( $terms ) {
			$terms = $terms->to_array();
		}
		$post = $post->to_array();
		if (
			empty( $post['image'] ) &&
			$terms &&
			isset( $terms[0] ) &&
			isset( $terms[0]['image'] )
		) {
			$post['image'] = $terms[0]['image']['url'];
		}
		$view_data = array(
			'post'  => $post,
			'terms' => $terms,
		);
		return array(
			'template' => 'TokenMeta.twig',
			'data'     => $view_data,
		);
	}
}
