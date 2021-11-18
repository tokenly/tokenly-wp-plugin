<?php

namespace Tokenly\Wp\Interfaces\Models;

interface WhitelistInterface {
	public function update( $whitelist_data );
	public function save();
	public function to_array();
}
