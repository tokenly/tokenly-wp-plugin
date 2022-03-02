<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;

use Tokenly\Wp\Collections\Credit\AccountCollection as CreditAccountCollection;
use Tokenly\Wp\Collections\Token\AddressCollection as TokenAddressCollection;
use Tokenly\Wp\Collections\Token\BalanceCollection as TokenBalanceCollection;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface as CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface as TokenAddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface as TokenBalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;

class OauthUser extends Model implements OauthUserInterface {
	protected ?string $id = null;
	protected ?string $username = null;
	protected ?string $email = null;
	protected ?string $name = null;
	protected ?bool $email_is_confirmed = false;
	protected ?string $oauth_token = null;
	protected ?TokenBalanceCollectionInterface $balance = null;
	/**
	 * Collection of blockchain addresses assigned to this account
	 * @var TokenAddressCollectionInterface|null $address
	 */
	protected ?TokenAddressCollectionInterface $address = null;
	protected ?CreditAccountCollectionInterface $credit_account = null;

	public function get_id(): ?string {
		return $this->id ?? null;
	}

	public function set_id( ?string $value ): void {
		$this->id = $value;
	}

	public function get_username(): ?string {
		return $this->username ?? null;
	}

	public function set_username( ?string $value ): void {
		$this->username = $value;
	}

	public function get_email(): ?string {
		return $this->email ?? null;
	}

	public function set_email( ?string $value ): void {
		$this->email = $value;
	}

	public function get_name(): ?string {
		return $this->name ?? null;
	}

	public function set_name( ?string $value ): void {
		$this->name = $value;
	}

	public function get_email_is_confirmed(): ?bool {
		return $this->email_is_confirmed ?? null;
	}

	public function set_email_is_confirmed( ?bool $value ): void {
		$this->email_is_confirmed = $value;
	}

	public function get_oauth_token(): ?string {
		return $this->oauth_token ?? null;
	}

	public function set_oauth_token( ?string $value ): void {
		$this->oauth_token = $value;
	}

	public function get_balance(): ?TokenBalanceCollectionInterface {
		return $this->balance ?? null;
	}

	public function set_balance( ?TokenBalanceCollectionInterface $value ): void {
		$this->balance = $value;
	}

	public function get_address(): ?TokenAddressCollectionInterface {
		return $this->address ?? null;
	}

	public function set_address( ?TokenAddressCollectionInterface $value ): void {
		$this->address = $value;
	}

	public function get_credit_account(): ?CreditAccountCollectionInterface {
		return $this->account ?? null;
	}

	public function set_credit_account( ?CreditAccountCollectionInterface $value ): void {
		$this->account = $value;
	}

	/**
	 * Check if the user is allowed to proceed with login
	 * @return bool
	 */
	public function can_social_login( OauthSettingsInterface $oauth_settings ): bool {
		$email = $this->get_email();
		$email_is_confirmed = $this->get_email_is_confirmed() ?? false;
		if ( !$email && $oauth_settings->get_allow_no_email() == false ) {
			return false;
		}
		if ( $email_is_confirmed == false && $oauth_settings->get_allow_unconfirmed_email() == false ) {
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
			'id'       => $this->get_id(),
			'username' => $this->get_username(),
		);
		if ( $this->get_address() ) {
			$array['address'] = $this->get_address()->to_array();
		}
		if ( $this->get_credit_account() ) {
			$array['credit_account'] = $this->get_credit_account()->to_array();
		}
		if ( $this->get_balance() ) {
			$array['balance'] = $this->get_balance()->to_array();
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
