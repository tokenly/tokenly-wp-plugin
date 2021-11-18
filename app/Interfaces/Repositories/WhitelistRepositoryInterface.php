<?php

namespace Tokenly\Wp\Interfaces\Repositories;

interface WhitelistRepositoryInterface {
	public function show();
	public function update( $settings );
}
