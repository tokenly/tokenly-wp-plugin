<?php

namespace Tokenly\Wp\Models\Routes;

use Tokenly\Wp\Models\Routes\Route;
use Tokenly\Wp\Interfaces\Models\Routes\WebRouteInterface;

class WebRoute extends Route implements WebRouteInterface {
	public ?string $id = null;
	public ?string $path = null;
	public mixed $callback = null;
	public ?array $rules = null;
	public ?array $vars = null;

	public function from_array( array $data = array() ): self {
		$path = $data['path'];
		$path_elements = preg_split(
			'/({[^}]*})/', $path, 0, PREG_SPLIT_DELIM_CAPTURE
		);
		$variables = array();
		foreach ( $path_elements as $key => &$element ) {
			if (
				str_contains( $element, '{' ) &&
				str_contains( $element, '}' )
			) {
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
