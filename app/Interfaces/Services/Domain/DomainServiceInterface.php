<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

interface DomainServiceInterface {
	public function load( $item, array $relations );
}
