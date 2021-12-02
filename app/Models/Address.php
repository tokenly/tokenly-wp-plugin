<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;

class Address extends Model implements AddressInterface {
	public $address = '';
	public $type = '';
	public $label = 'Unnamed';
	public $balances;
	protected $fillable = array(
		'address',
		'type',
		'label',
		'balances',
	);

	public function __construct(
		SourceRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		parent::__construct( $data );
	}
}
