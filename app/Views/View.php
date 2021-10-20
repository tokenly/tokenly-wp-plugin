<?php

namespace Tokenly\Wp\Views;
use Twig\Environment;

class View {
	public $twig;

	public function __construct( Environment $twig ) {
		$this->twig = $twig;
	}
}