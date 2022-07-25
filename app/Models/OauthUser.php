<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

use Tokenly\Wp\Collections\Credit\AccountCollection as CreditAccountCollection;
use Tokenly\Wp\Collections\Token\AddressCollection as TokenAddressCollection;
use Tokenly\Wp\Collections\Token\BalanceCollection as TokenBalanceCollection;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface
	as CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface
	as TokenAddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface
	as TokenBalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class OauthUser extends Model implements OauthUserInterface {
	public ?string $id = null;
	public ?string $username = null;
	public ?string $email = null;
	public ?string $name = null;
	public ?bool $email_is_confirmed = false;
	public ?string $oauth_token = null;
	public ?TokenBalanceCollectionInterface $balance = null;
	/**
	 * Collection of blockchain addresses assigned to this account
	 * @var TokenAddressCollectionInterface|null $address
	 */
	public ?TokenAddressCollectionInterface $address = null;
	public ?CreditAccountCollectionInterface $credit_account = null;

	/**
	 * Check if the user is allowed to proceed with login
	 * @return bool
	 */
	public function can_social_login(
		OauthSettingsInterface $oauth_settings
	): bool {
		$email = $this->email;
		$email_is_confirmed = $this->email_is_confirmed ?? false;
		if ( !$email && $oauth_settings->allow_no_email == false ) {
			return false;
		}
		if (
			$email_is_confirmed == false &&
			$oauth_settings->allow_unconfirmed_email == false
		) {
			return false;	
		}
		return true;
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
		$array = array(
			'id'       => $this->id,
			'username' => $this->username,
		);
		if ( $this->address ) {
			$array['address'] = $this->address->to_array();
		}
		if ( $this->credit_account ) {
			$array['credit_account'] = $this->credit_account->to_array();
		}
		if ( $this->balance ) {
			$array['balance'] = $this->balance->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'id',
			'username',
			'email',
			'name',
			'email_is_confirmed',
			'oauth_token',
		) );
	}
}
