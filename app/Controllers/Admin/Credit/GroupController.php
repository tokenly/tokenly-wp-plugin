<?php

namespace Tokenly\Wp\Controllers\Admin\Credit;

use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\GroupControllerInterface;

use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupWhitelistEditViewModelInterface;

/**
 * Serves the admin credit group views
 */
class GroupController implements GroupControllerInterface {
	protected GroupStoreViewModelInterface $store_view_model;
	protected GroupWhitelistEditViewModelInterface $whitelist_edit_view_model;

	public function __construct(
		GroupStoreViewModelInterface $store_view_model,
		GroupWhitelistEditViewModelInterface $whitelist_edit_view_model
	) {
		$this->store_view_model = $store_view_model;
		$this->whitelist_edit_view_model = $whitelist_edit_view_model;
	}

	public function index(): array {
		return array(
			'view' => 'credit-group-index',
		);
	}
	
	public function show(): array {
		return array(
			'view' => 'credit-group-show',
		);
	}

	public function store(): array {
		$view_data = $this->store_view_model->prepare();
		return array(
			'view' => 'credit-group-store',
			'data' => $view_data,
		);
	}

	public function edit(): array {
		return array(
			'view' => 'credit-group-edit',
		);
	}

	public function whitelist_edit(): array {
		$view_data = $this->whitelist_edit_view_model->prepare();
		return array(
			'view' => 'credit-group-whitelist-edit',
			'data' => $view_data,
		);
	}

	public function account_index(): array {
		return array(
			'view' => 'credit-group-account-index',
		);
	}
}
