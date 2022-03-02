<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;

class PromiseMeta extends Post implements PromiseMetaInterface {
	protected ?int $promise_id = null;
	protected ?string $source_user_id = null;
	protected ?UserInterface $source_user = null;
	protected ?string $destination_user_id = null;
	protected ?UserInterface $destination_user = null;

	public function get_promise_id(): ?int {
		return $this->promise_id ?? null;
	}

	public function set_promise_id( ?int $value ): void {
		$this->promise_id = $value;
	}

	public function get_source_user_id(): ?string {
		return $this->source_user_id ?? null;
	}

	public function set_source_user_id( ?string $value ): void {
		$this->source_user_id = $value;
	}

	public function get_source_user(): ?UserInterface {
		return $this->source_user ?? null;
	}

	public function set_source_user( ?UserInterface $value ): void {
		$this->source_user = $value;
	}

	public function get_destination_user_id(): ?string {
		return $this->destination_user_id ?? null;
	}

	public function set_destination_user_id( ?string $value ): void {
		$this->destination_user_id = $value;
	}

	public function get_destination_user(): ?UserInterface {
		return $this->destination_user ?? null;
	}

	public function set_destination_user( ?UserInterface $value ): void {
		$this->destination_user = $value;
	}

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
			'promise_id'          => $this->get_promise_id(),
			'source_user_id'      => $this->get_source_user_id(),
			'destination_user_id' => $this->get_destination_user_id(),
		);
		if ( $this->get_source_user() ) {
			$array['source_user'] = $this->get_source_user()->to_array();
		}
		if ( $this->get_destination_user() ) {
			$array['destination_user'] = $this->get_destination_user()->to_array();
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
