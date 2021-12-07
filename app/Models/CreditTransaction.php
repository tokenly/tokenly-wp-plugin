<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CreditTransactionInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditTransactionRepositoryInterface;

class CreditTransaction extends Model implements CreditTransactionInterface {
	public $uuid;
	public $app_credit_group_uuid;
	public $account_uuid;
	public $account_name;
	public $amount;
	public $ref;
	public $created_at;
	public $updated_at;
	protected $fillable = array(
		'uuid',
		'app_credit_group_uuid',
		'account_uuid',
		'account_name',
		'amount',
		//'ref',
		'created_at',
		'updated_at',
	);

	public function __construct(
		CreditTransactionRepositoryInterface $domain_repository,
		array $data = array()
	) {
		$this->domain_repository = $domain_repository;
		parent::__construct( $data );
	}

}
