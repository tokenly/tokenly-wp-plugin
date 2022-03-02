<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\QuantityInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface as TokenMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;

class Promise extends Model implements PromiseInterface {
	protected ?string $source_id = null;
	protected ?SourceInterface $source = null;
	protected ?string $destination = null;
	protected ?AssetInterface $asset = null;
	protected ?QuantityInterface $quantity = null;
	protected ?string $fingerprint = null;
	protected ?string $txid = null;
	protected ?string $created_at = null;
	protected ?string $updated_at = null;
	protected ?string $expiration = null;
	protected ?string $ref = null;
	protected ?bool $pseudo = null;
	protected ?string $note = null;
	protected ?string $protocol = null;
	protected ?string $chain = null;
	protected ?int $promise_id = null;
	protected ?TokenMetaInterface $token_meta = null;
	protected ?PromiseMetaInterface $promise_meta = null;

	public function get_source_id(): ?string {
		return $this->source_id ?? null;
	}

	public function set_source_id( ?string $value ): void {
		$this->source_id = $value;
	}

	public function get_source(): ?SourceInterface {
		return $this->source ?? null;
	}

	public function set_source( ?SourceInterface $value ): void {
		$this->source = $value;
	}

	public function get_destination(): ?string {
		return $this->destination ?? null;
	}

	public function set_destination( ?string $value ): void {
		$this->destination = $value;
	}

	public function get_asset(): ?AssetInterface {
		return $this->asset ?? null;
	}

	public function set_asset( ?AssetInterface $value ): void {
		$this->asset = $value;
	}

	public function get_quantity(): ?QuantityInterface {
		return $this->quantity ?? null;
	}

	public function set_quantity( ?QuantityInterface $value ): void {
		$this->quantity = $value;
	}

	public function get_fingerprint(): ?string {
		return $this->fingerprint ?? null;
	}

	public function set_fingerprint( ?string $value ): void {
		$this->fingerprint = $value;
	}

	public function get_txid(): ?string {
		return $this->txid ?? null;
	}

	public function set_txid( ?string $value ): void {
		$this->txid = $value;
	}

	public function get_created_at(): ?string {
		return $this->created_at ?? null;
	}

	public function set_created_at( ?string $value ): void {
		$this->created_at = $value;
	}

	public function get_updated_at(): ?string {
		return $this->updated_at ?? null;
	}

	public function set_updated_at( ?string $value ): void {
		$this->updated_at = $value;
	}

	public function get_expiration(): ?string {
		return $this->expiration ?? null;
	}

	public function set_expiration( ?string $value ): void {
		$this->expiration = $value;
	}

	public function get_ref(): ?string {
		return $this->ref ?? null;
	}

	public function set_ref( ?string $value ): void {
		$this->ref = $value;
	}

	public function get_pseudo(): ?bool {
		return $this->pseudo ?? null;
	}

	public function set_pseudo( bool $value ): void {
		$this->pseudo = $value;
	}

	public function get_note(): ?string {
		return $this->note ?? null;
	}

	public function set_note( ?string $value ): void {
		$this->note = $value;
	}

	public function get_protocol(): ?string {
		return $this->protocol ?? null;
	}

	public function set_protocol( ?string $value ) {
		$this->protocl = $value;
	}

	public function get_chain(): ?string {
		return $this->chain ?? null;
	}

	public function set_chain( ?string $value ) {
		$this->chain = $value;
	}

	public function get_promise_id(): ?int {
		return $this->promise_id ?? null;
	}

	public function set_promise_id( ?int $value ): void {
		$this->promise_id = $value;
	}

	public function get_token_meta(): ?TokenMetaInterface {
		return $this->token_meta ?? null;
	}

	public function set_token_meta( ?TokenMetaInterface $value ) {
		$this->token_meta = $value;
	}

	public function get_promise_meta(): ?PromiseMetaInterface {
		return $this->promise_meta ?? null;
	}

	public function set_promise_meta( ?PromiseMetaInterface $value ): void {
		$this->promise_meta = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		if ( isset( $data['quantity'] ) && is_array( $data['quantity'] ) ) {
			$data['quantity'] = ( new Quantity() )->from_array( $data['quantity'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'source_id'   => $this->get_source_id(),
			'destination' => $this->get_destination(),
			'fingerprint' => $this->get_fingerprint(),
			'txid'        => $this->get_txid(),
			'created_at'  => $this->get_created_at(),
			'updated_at'  => $this->get_updated_at(),
			'expiration'  => $this->get_expiration(),
			'ref'         => $this->get_ref(),
			'pseudo'      => $this->get_pseudo(),
			'note'        => $this->get_note(),
			'protocol'    => $this->get_protocol(),
			'chain'       => $this->get_chain(),
			'promise_id'  => $this->get_promise_id(),
		);
		if ( $this->get_asset() ) {
			$array['asset'] = $this->get_asset()->to_array();
		}
		if ( $this->get_source() ) {
			$array['source'] = $this->get_source()->to_array();
		}
		if ( $this->get_quantity() ) {
			$array['quantity'] = $this->get_quantity()->to_array();
		}
		if ( $this->get_promise_meta() ) {
			$array['promise_meta'] = $this->get_promise_meta()->to_array();
		}
		if ( $this->get_token_meta() ) {
			$array['token_meta'] = $this->get_token_meta()->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'source_id',
			'destination',
			'asset',
			'quantity',
			'fingerprint',
			'txid',
			'created_at',
			'updated_at',
			'expiration',
			'ref',
			'pseudo',
			'note',
			'protocol',
			'chain',
			'promise_id',
		) );
	}
}
