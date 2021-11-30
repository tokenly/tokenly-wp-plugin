<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface WhitelistServiceInterface {
	public function show();
	public function update( array $options );
}
