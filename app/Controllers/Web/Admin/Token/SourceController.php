<?php

namespace Tokenly\Wp\Controllers\Web\Admin\Token;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\SourceControllerInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\SourceEditViewModelInterface;

/**
 * Serves the admin source views
 */
class SourceController implements SourceControllerInterface {
	protected $index_view_model;
	protected $show_view_model;
	protected $store_view_model;
	protected $edit_view_model;

	public function __construct(
		SourceIndexViewModelInterface $index_view_model,
		SourceShowViewModelInterface $show_view_model,
		SourceStoreViewModelInterface $store_view_model,
		SourceEditViewModelInterface $edit_view_model
	) {
		$this->index_view_model = $index_view_model;
		$this->show_view_model = $show_view_model;
		$this->store_view_model = $store_view_model;
		$this->edit_view_model = $edit_view_model;
	}

	public function index() {
		$view_data = $this->index_view_model->prepare();
		return array(
			'view' => 'token-source-index',
			'data' => $view_data,
		);
	}

	public function show() {
		$input_data = array();
		if ( isset( $_GET['source'] ) ) {
			$input_data['source'] = $_GET['source'];
		} else {
			return false;
		}
		$view_data = $this->show_view_model->prepare( $input_data );
		return array(
			'view' => 'token-source-show',
			'data' => $view_data,
		);
	}

	public function store() {
		$view_data = $this->store_view_model->prepare();
		return array(
			'view' => 'token-source-store',
			'data' => $view_data,
		);
	}

	public function edit() {
		$input_data = array();
		if ( isset( $_GET['source'] ) ) {
			$input_data['source'] = $_GET['source'];
		} else {
			return false;
		}
		$view_data = $this->edit_view_model->prepare( $input_data );
		return array(
			'view' => 'token-source-edit',
			'data' => $view_data,
		);
	}
}
