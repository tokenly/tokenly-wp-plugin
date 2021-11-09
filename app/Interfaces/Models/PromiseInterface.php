<?php

namespace Tokenly\Wp\Interfaces\Models;

interface PromiseInterface {
	public function update( $params );
	public function destroy();
}
