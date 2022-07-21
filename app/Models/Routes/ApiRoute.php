<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\ApiRouteInterface;

class ApiRoute extends Route implements ApiRouteInterface {
	public ?string $path = null;
	public ?string $path_regex = null;
	public ?string $methods = null;
	public mixed $callback;
	public mixed $permission_callback;

	public function get_register_arguments(): array {
		return array(
			$this->path_regex,
			array(
				'methods'             => $this->methods,
				'callback'            => $this->callback,
				'permission_callback' => $this->permission_callback,
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['path'] ) ) {
			$data['path_regex'] = $this->parse_path( $data['path'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'path',
			'path_regex',
			'methods',
			'callback',
			'permission_callback',
		) );
	}

	/**
	 * Replaces variables in curly braces with regex
	 * to make them processable via REST API
	 * @param string $path Endpoint path
	 * @return string $path Formatted path
	 */
	protected function parse_path( string $path ): string {
		$sections = preg_split( '/({[^}]*})/', $path, 0, PREG_SPLIT_DELIM_CAPTURE );
		foreach ( $sections as &$section ) {
			if ( $this->is_section_variable( $section ) ) {
				$section = $this->variable_to_regex( $section );
			}
		}
		$path = implode( '', $sections );
		return $path;
	}

	protected function is_section_variable( string $section ): bool {
		return ( str_contains( $section, '{' ) && str_contains( $section, '}' ) );
	}

	protected function variable_to_regex( string $section ): string {
		$variable = str_replace( array( '{', '}' ), '', $section );
		$section = "(?P<{$variable}>\S+)";
		return $section;
	}
}
