<?php

namespace Tokenly\Wp\Views;

use Tokenly\Wp\Views\View;
use Twig\Environment;

class WebView extends View {
	protected $name;

	public function __construct(
		Environment $twig
	) {
		parent::__construct( $twig );
		add_filter( 'body_class',  array( $this, 'add_body_classes' ) );
	}

	public function render( array $data = array() ) {
		$html_header = $this->render_header();
		$html_content = $this->render_content( $data );
		$html_footer = $this->render_footer();
		$html = $this->twig->render( 'Web.twig', array(
			'header'   => $html_header,
			'content'  => $html_content,
			'footer'   => $html_footer,
		) );
		return $html;
	}

	public function render_content( array $data = array() ) {
		//
	}

	public function add_body_classes( array $classes ) {
		$classes[] = "tokenly-page";
		$classes[] = "tokenly-page-{$this->name}";
		return $classes;
	}

	protected function render_header() {
		ob_start();
			get_header();
		return ob_get_clean();
	}

	protected function render_footer() {
		ob_start();
			get_footer();
		return ob_get_clean();
	}
}
