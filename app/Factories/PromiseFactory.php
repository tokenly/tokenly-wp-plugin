<?php

namespace Tokenly\Wp\Factories;

use Tokenly\Wp\Interfaces\Factories\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Factories\Factory;

class PromiseFactory extends Factory implements PromiseFactoryInterface {
	/**
	 * Creates a new promise object
	 * @param array $promise_data New promise data
	 * @return PromiseInterface
	 */
	public function create( $params ) {
		$promise = $this->factory->create( array(
			'promise_data' => array(
				'source'       => $params['source']       ?? null,
				'destination'  => $params['destination']  ?? null,
				'asset'        => $params['asset']        ?? null,
				'quantity'     => $params['quantity']     ?? null,
				'fingerprint'  => $params['fingerprint']  ?? null,
				'txid'         => $params['txid']         ?? null,
				'created_at'   => $params['created_at']   ?? null,
				'updated_at'   => $params['updated_at']   ?? null,
				'expiration'   => $params['expiration']   ?? null,
				'ref'          => $params['ref']          ?? null,
				'pseudo'       => $params['pseudo']       ?? null,
				'note'         => $params['note']         ?? null,
				'protocol'     => $params['protocol']     ?? null,
				'chain'        => $params['chain']        ?? null,
				'promise_id'   => $params['promise_id']   ?? null,
				'precision'    => $params['precision']    ?? null,
			),
		) );
		return $promise;
	}
}
