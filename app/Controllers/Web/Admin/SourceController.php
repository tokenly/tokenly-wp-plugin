<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Views\Admin\SourceIndexView;
use Tokenly\Wp\Views\Admin\SourceShowView;
use Tokenly\Wp\Views\Admin\SourceStoreView;
use Tokenly\Wp\Views\Admin\SourceEditView;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;

/**
 * Serves the admin source views
 */
class SourceController implements SourceControllerInterface {
	protected $source_index_view;
	protected $source_show_view;
	protected $source_store_view;
	protected $source_edit_view;
	protected $source_service;
	protected $current_user;

	public function __construct(
		SourceIndexView $source_index_view,
		SourceShowView $source_show_view,
		SourceStoreView $source_store_view,
		SourceEditView $source_edit_view,
		SourceServiceInterface $source_service,
		CurrentUserInterface $current_user
	) {
		$this->source_index_view = $source_index_view;
		$this->source_show_view = $source_show_view;
		$this->source_store_view = $source_store_view;
		$this->source_edit_view = $source_edit_view;
		$this->source_service = $source_service;
		$this->current_user = $current_user;
	}

	public function index() {
		$sources = $this->source_service->index( array(
			'with' => array(
				'address',
			),
		) );
		$sources = $sources->to_array();
		$render = $this->source_index_view->render( array(
			'sources' => $sources,
		) );
		return $render;
	}

	public function show() {
		$address = $_GET['source'] ?? null;
		$source = $this->source_service->show( array(
			'address' => $address,
			'with'    => array(
				'address',
			),
		) );
		if ( !$source ) {
			return;
		}
		$source = $source->to_array();
		$render = $this->source_show_view->render( array(
			'source' => $source,
		) );
		return $render;
	}

	public function store() {
		if ( !isset( $this->current_user ) ) {
			return;
		}
		$addresses = $this->current_user->get_addresses(
			array(
				'with' => array( 'balances.token_meta' ),
			)
		);
		$addresses = $addresses->to_array();
		$render = $this->source_store_view->render( array(
			'addresses' => $addresses,
		) );
		return $render;
	}

	public function edit() {
		$source_address = $_GET['source'] ?? null;
		$source = $this->source_service->show( array(
			'address' => $source_address,
			'with'    => array(
				'address',
			),
		) );
		$render = $this->source_edit_view->render( array(
			'source' => $source,
		) );
		return $render;
	}
}
