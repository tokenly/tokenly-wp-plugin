<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\WebRouteInterface;

class WebRoute extends Route implements WebRouteInterface {
	protected ?string $id = null;
	protected ?string $path = null;
	protected mixed $callback;
	protected ?array $rules = null;
	protected ?array $vars = null;

	public function get_id(): ?string {
		return $this->id ?? null;
	}

	public function set_id( ?string $value ): void {
		$this->id = $value;
	}

	public function get_path(): ?string {
		return $this->path ?? null;
	}

	public function set_path( ?string $value ): void {
		$this->path = $value;
	}

	public function get_callback(): ?callable {
		return $this->callback ?? null;
	}

	public function set_callback( ?callable $value ): void {
		$this->callback = $value;
	}

	public function get_rules(): ?array {
		return $this->rules ?? null;
	}

	public function set_rules( ?array $value ): void {
		$this->rules = $value;
	}

	public function get_vars(): ?array {
		return $this->vars ?? null;
	}

	public function set_vars( ?array $value ): void {
		$this->vars = $value;
	}

	public function from_array( array $data = array() ): self {
		$path = $data['path'];
		$path_elements = preg_split( '/({[^}]*})/', $path, 0, PREG_SPLIT_DELIM_CAPTURE );
		$variables = array();
		foreach ( $path_elements as $key => &$element ) {
			if ( str_contains( $element, '{' ) && str_contains( $element, '}' ) ) {
				$element = str_replace( '{', '', $element );
				$element = str_replace( '}', '', $element );
				$variables[ $element ] = '$matches[' . $key . ']';
				$element = "([^/]*)";
			}
		}
		$id = $data['id'];
		$variables[ "{$id}_page" ] = 1;
		$path = implode( '', $path_elements );
		$data['rules'] = array( $path );
		$data['vars'] = $variables;
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'id',
			'path',
			'callback',
			'rules',
			'vars',
		) );
	}
}
