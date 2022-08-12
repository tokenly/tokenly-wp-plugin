<?php

namespace Tokenly\Wp\Services\Application;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\ViewRendererInterface;
use Twig\Environment;

/**
 * Base router
 */
class ViewRenderer extends Service implements ViewRendererInterface {
	protected string $namespace;
    protected Environment $twig;

	public function __construct(
        string $namespace,
        Environment $twig
    ) {
		$this->namespace = $namespace;
        $this->twig = $twig;
	}

	/**
	 * Executes the specified render callback
	 * @param callable $render_function Controller's render function
	 * @return void
	 */
	public function render(
        callable $render_function,
		array $arguments = array(),
		string $fallback_template = 'Index.twig'
	): void {
		nocache_headers();
		$response = call_user_func( $render_function, ...$arguments );
		if ( !$response ) {
			return;
		}
		$view_data = array();
		$template = $fallback_template;
		if ( isset( $response['view'] ) ) {
			$view_data['view'] = $response['view'];
		}
		if ( isset( $response['template'] ) ) {
			$template = $response['template'];
		}
		$props = array();
		if ( isset( $response['data'] ) ) {
			$props = $response['data'];
		}
		if ( $template == 'Dynamic.twig' ) {
			$props = htmlspecialchars(
				json_encode( $props ),
				ENT_QUOTES,
				'UTF-8'
			);
		}
		$view_data['props'] = $props;
		$view_data['namespace'] = $this->namespace;
		$view_data['template'] = $template;
		$view_data = apply_filters( "{$this->namespace}-view-data", $view_data );
		$html = $this->twig->render( $template, $view_data );	
		echo $html;
	}
}
