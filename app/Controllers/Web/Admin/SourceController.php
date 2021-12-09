<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;
use Tokenly\Wp\ViewModels\Admin\SourceIndexViewModel;
use Tokenly\Wp\ViewModels\Admin\SourceShowViewModel;
use Tokenly\Wp\ViewModels\Admin\SourceStoreViewModel;
use Tokenly\Wp\ViewModels\Admin\SourceEditViewModel;

/**
 * Serves the admin source views
 */
class SourceController implements SourceControllerInterface {
	protected $source_index_view_model;
	protected $source_show_view_model;
	protected $source_store_view_model;
	protected $source_edit_view_model;

	public function __construct(
		SourceIndexViewModel $source_index_view_model,
		SourceShowViewModel $source_show_view_model,
		SourceStoreViewModel $source_store_view_model,
		SourceEditViewModel $source_edit_view_model
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
