<?php

namespace Tokenly\Wp\Interfaces;

interface BootstrapInterface {
	public function get_providers();
	public function register_providers();
	public function build_container();
}
