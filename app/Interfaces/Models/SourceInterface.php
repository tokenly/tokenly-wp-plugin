<?php

namespace Tokenly\Wp\Interfaces\Models;

interface SourceInterface {
	public function update( $params );
	public function destroy();
}
