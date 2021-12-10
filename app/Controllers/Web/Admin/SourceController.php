<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceEditViewModelInterface;

/**
 * Serves the admin source views
 */
class SourceController implements SourceControllerInterface {
	protected $source_index_view_model;
	protected $source_show_view_model;
	protected $source_store_view_model;
	protected $source_edit_view_model;

	public function __construct(
		SourceIndexViewModelInterface $source_index_view_model,
		SourceShowViewModelInterface $source_show_view_model,
		SourceStoreViewModelInterface $source_store_view_model,
		SourceEditViewModelInterface $source_edit_view_model
	) {
		$this->source_index_view_model = $source_index_view_model;
		$this->source_show_view_model = $source_show_view_model;
		$this->source_store_view_model = $source_store_view_model;
		$this->source_edit_view_model = $source_edit_view_model;
	}

	public function index() {
		$view_data = $this->source_index_view_model->prepare();
		return $view_data;
	}

	public function show() {
		if ( !isset( $_GET['source'] ) ) {
			return false;
		}
		$input_data = array(
			'source' => $_GET['source'],
		);
		$view_data = $this->source_show_view_model->prepare( $input_data );
		return $view_data;
	}

	public function store() {
		$view_data = $this->source_store_view_model->prepare();
		return $view_data;
	}

	public function edit() {
		if ( !isset( $_GET['source'] ) ) {
			return false;
		}
		$input_data = array(
			'source_id' => $_GET['source'],
		);
		$view_data = $this->source_edit_view_model->prepare( $input_data );
		return $view_data;
	}
}
