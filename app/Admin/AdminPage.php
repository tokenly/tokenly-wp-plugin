<?php

namespace Tokenly\Wp\Admin;

class AdminPage {
	public $settings;
	public $settings_group;
	public $route_args;
	public $page_slug;

	public function __construct( $route_args ) {
		$this->route_args = $route_args;
		$this->page_slug = $this->route_args['menu_slug'] ?? null;
	}

	public function register_settings() {
		//
	}

	public function page_callback() {
		//
	}
}
