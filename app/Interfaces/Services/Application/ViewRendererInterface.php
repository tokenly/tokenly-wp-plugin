<?php

namespace Tokenly\Wp\Interfaces\Services\Application;

use Tokenly\Wp\Interfaces\Services\ServiceInterface;

interface ViewRendererInterface extends ServiceInterface {
	public function render(
		callable $render_function, array $arguments = array(), string $fallback_template
	);
}
