<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\CreditTransactionInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class CreditTransaction extends Model implements CreditTransactionInterface {
	public $tx_uuid;
	public $credit_group;
	public $account_uuid;
	public $account;
	public $user;
	public $amount;
	public $oauth_user_id;
	public $ref;
	public $created_at;
	public $updated_at;
	protected $oauth_user_service;
	protected $user_service;
	protected $fillable = array(
		'credit_group',
		'tx_uuid',
		'user',
		'account_uuid',
		'account',
		'amount',
		'oauth_user_id',
		//'ref',
		'created_at',
		'updated_at',
	);

	public function __construct(
		OauthUserServiceInterface $oauth_user_service,
		UserServiceInterface $user_service,
		array $data = array()
	) {
		$this->oauth_user_service = $oauth_user_service;
		$this->user_service = $user_service;
		parent::__construct( $data );
	}

	/**
	 * Loads the user relation
	 * @param string[] $relations Further relations
	 * @return self
	 */
	protected function load_user( array $relations = array() ) {
		$user = $this->user_service->show( array(
			'uuid' => $this->account,
			'with' => $relations,
		) );
		$this->user = $user;
		return $this;
	}
}
