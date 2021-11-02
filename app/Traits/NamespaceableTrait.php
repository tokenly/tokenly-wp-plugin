<?php

namespace Tokenly\Wp\Traits;

trait NamespaceableTrait {
	public $namespace = 'tokenly';

	public function namespace_key( $key ) {
		return $this->namespace . '_' . $key;
	}
}
