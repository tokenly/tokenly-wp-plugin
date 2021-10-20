<?php

namespace Tokenly\Wp\Components;
use Twig\Environment;

class Component {
	public $twig;

	public function __construct( Environment $twig ) {
		$this->twig = $twig;
	}
}