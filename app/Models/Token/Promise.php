<?php

namespace Tokenly\Wp\Models\Token;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface;

use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\QuantityInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface as TokenMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\AssetInterface;

class Promise extends Model implements PromiseInterface {
	public ?string $source_id = null;
	public ?SourceInterface $source = null;
	public ?string $destination = null;
	public ?AssetInterface $asset = null;
	public ?QuantityInterface $quantity = null;
	public ?string $fingerprint = null;
	public ?string $txid = null;
	public ?string $created_at = null;
	public ?string $updated_at = null;
	public ?string $expiration = null;
	public ?string $ref = null;
	public ?bool $pseudo = null;
	public ?string $note = null;
	public ?string $protocol = null;
	public ?string $chain = null;
	public ?int $promise_id = null;
	public ?TokenMetaInterface $token_meta = null;
	public ?PromiseMetaInterface $promise_meta = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['asset'] ) && is_array( $data['asset'] ) ) {
			$data['asset'] = ( new Asset() )->from_array( $data['asset'] );
		}
		if ( isset( $data['quantity'] ) && is_array( $data['quantity'] ) ) {
			$data['quantity']
				= ( new Quantity() )->from_array( $data['quantity'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'source_id'   => $this->source_id,
			'destination' => $this->destination,
			'fingerprint' => $this->fingerprint,
			'txid'        => $this->txid,
			'created_at'  => $this->created_at,
			'updated_at'  => $this->updated_at,
			'expiration'  => $this->expiration,
			'ref'         => $this->ref,
			'pseudo'      => $this->pseudo,
			'note'        => $this->note,
			'protocol'    => $this->protocol,
			'chain'       => $this->chain,
			'promise_id'  => $this->promise_id,
		);
		if ( $this->asset ) {
			$array['asset'] = $this->asset->to_array();
		}
		if ( $this->source ) {
			$array['source'] = $this->source->to_array();
		}
		if ( $this->quantity ) {
			$array['quantity'] = $this->quantity->to_array();
		}
		if ( $this->promise_meta ) {
			$array['promise_meta'] = $this->promise_meta->to_array();
		}
		if ( $this->token_meta ) {
			$array['token_meta'] = $this->token_meta->to_array();
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
