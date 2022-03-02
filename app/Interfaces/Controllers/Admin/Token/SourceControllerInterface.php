<?php

namespace Tokenly\Wp\Interfaces\Controllers\Admin\Token;

interface SourceControllerInterface {
	public function index();
	public function store();
	public function edit();
}
