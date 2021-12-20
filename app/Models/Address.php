<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

class Address extends Model implements AddressInterface {
	public $address = '';
	public $type = '';
	public $label = 'Unnamed';
	public $balance;
	protected $fillable = array(
		'address',
		'type',
		'label',
		'balance',
	);

	public function __construct(
		AddressRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		parent::__construct( $data );
	}

	/**
	 * Loads the balance relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_balance( array $relations ) {
		if ( isset( $this->balance ) ) {
			$this->balance->load( $relations );
		}
		return $this->balance;
	}
}
