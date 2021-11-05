<?php

namespace Tokenly\Wp\Controllers\Web\Admin;

use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Views\Admin\WhitelistView;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;

/**
 * Serves the admin Whitelist view
 */
class WhitelistController implements WhitelistControllerInterface {
	public $whitelist_view;
	public $whitelist_repository;

	public function __construct(
		WhitelistView $whitelist_view,
		WhitelistRepositoryInterface $whitelist_repository
	) {
		$this->whitelist_view = $whitelist_view;
		$this->whitelist_repository = $whitelist_repository;
	}

	public function show() {
		$whitelist = $this->whitelist_repository->show();
		$render = $this->whitelist_view->render( array(
			'whitelist' => $whitelist,
		) );
		echo $render;
	}
}
