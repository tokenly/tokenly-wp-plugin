<?php

namespace Tokenly\Wp\Interfaces\Services;

interface WhitelistRepositoryInterface {
	public function show();
	public function update( $settings );
}
