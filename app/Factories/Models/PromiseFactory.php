<?php

namespace Tokenly\Wp\Factories\Models;

use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Factories\Factory;

class PromiseFactory extends Factory implements PromiseFactoryInterface {
	/**
	 * Creates a new promise object
	 * @param array $promise_data New promise data
	 * @return PromiseInterface
	 */
	public function create( $data, $args = array() ) {
		$quantity = $data['quantity'] ?? null;
		error_log( print_r( $data, true ) );
		if ( $quantity ) {
			$precision = $data['precision'] ?? null;
			if ( $precision ) {
				$divisor = intval( 1 . str_repeat( 0, $precision ) );
				$quantity = $quantity / $divisor;
			}
		}
		$promise = $this->factory->create( array(
			'promise_data' => array(
				'source'       => $data['source']       ?? null,
				'destination'  => $data['destination']  ?? null,
				'asset'        => $data['asset']        ?? null,
				'quantity'     => $quantity,
				'quantity_sat' => $data['quantity']     ?? null,
				'fingerprint'  => $data['fingerprint']  ?? null,
				'txid'         => $data['txid']         ?? null,
				'created_at'   => $data['created_at']   ?? null,
				'updated_at'   => $data['updated_at']   ?? null,
				'expiration'   => $data['expiration']   ?? null,
				'ref'          => $data['ref']          ?? null,
				'pseudo'       => $data['pseudo']       ?? null,
				'note'         => $data['note']         ?? null,
				'protocol'     => $data['protocol']     ?? null,
				'chain'        => $data['chain']        ?? null,
				'promise_id'   => $data['promise_id']   ?? null,
				'precision'    => $data['precision']    ?? null,
			),
		) );
		return $promise;
	}
}
