<?php

namespace Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token;

interface SourceControllerInterface {
	public function index();
	public function store();
	public function edit();
}
