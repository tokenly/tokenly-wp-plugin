<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\ApiRouteInterface;

class ApiRoute extends Route implements ApiRouteInterface {
	protected ?string $path = null;
	protected ?string $path_regex = null;
	protected ?string $methods = null;
	protected mixed $callback;
	protected mixed $permission_callback;

	public function get_path(): ?string {
		return $this->path ?? null;
	}

	public function set_path( ?string $value ): void {
		$this->path = $value;
	}

	public function get_path_regex(): ?string {
		return $this->path_regex ?? null;
	}

	public function set_path_regex( ?string $value ): void {
		$this->path_regex = $value;
	}

	public function get_methods(): ?string {
		return $this->methods ?? null;
	}

	public function set_methods( ?string $value ): void {
		$this->methods = $value;
	}

	public function get_callback(): ?callable {
		return $this->callback ?? null;
	}

	public function set_callback( ?callable $value ): void {
		$this->callback = $value;
	}

	public function get_permission_callback(): ?callable {
		return $this->permission_callback ?? null;
	}

	public function set_permission_callback( ?callable $value ): void {
		$this->permission_callback = $value;
	}

	public function get_register_arguments(): array {
		return array(
			$this->get_path_regex(),
			array(
				'methods'             => $this->get_methods(),
				'callback'            => $this->get_callback(),
				'permission_callback' => $this->get_permission_callback(),
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
