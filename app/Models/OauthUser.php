<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;

class OauthUser extends Model implements OauthUserInterface {
	public $id;
	public $username;
	public $email;
	public $name;
	public $email_is_confirmed;
	public $oauth_token;
	public $balances;
	public $addresses;
	protected $tca_service;
	protected $oauth_user_service;
	protected $fillable = array(
		'id',
		'username',
		'email',
		'name',
		'email_is_confirmed',
		'oauth_token',
		'balances',
		'addresses',
	);

	public function __construct(
		TcaServiceInterface $tca_service,
		OauthUserServiceInterface $domain_service,
		array $data = array()
	) {
		$this->tca_service = $tca_service;
		$this->domain_service = $domain_service;
		parent::__construct( $data );
	}

	/**
	 * Check if the user is allowed to proceed with login
	 * @param array $tokenpass_user
	 * @return bool
	 */
	public function can_social_login() {
		$email = $this->email ?? null;
		$email_is_confirmed = $this->email_is_confirmed ?? null;
		if ( !$email || $email_is_confirmed == false ) {
			return false;	
		}
		return true;
	}

	/**
	 * Checks if the user can pass TCA with the specified rules
	 * @param TcaRuleCollectionInterface $rules TCA rules
	 * @return bool
	 */
	public function check_token_access( TcaRuleCollectionInterface $rules ) {
		$can_access = $this->tca_service->check_token_access_user( $this, $rules );
		return $can_access;
	}
}
