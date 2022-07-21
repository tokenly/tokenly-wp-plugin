<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;

class PromiseMeta extends Post implements PromiseMetaInterface {
	public ?int $promise_id = null;
	public ?string $source_user_id = null;
	public ?UserInterface $source_user = null;
	public ?string $destination_user_id = null;
	public ?UserInterface $destination_user = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array_parent = parent::to_array();
		$array = array(
			'promise_id'          => $this->promise_id,
			'source_user_id'      => $this->source_user_id,
			'destination_user_id' => $this->destination_user_id,
		);
		if ( $this->source_user ) {
			$array['source_user'] = $this->source_user->to_array();
		}
		if ( $this->destination_user ) {
			$array['destination_user'] = $this->destination_user->to_array();
		}
		$array = array_merge( $array, $array_parent );
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'promise_id',
			'source_user_id',
			'destination_user_id',
		) );
	}
}
