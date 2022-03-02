<?php

namespace Tokenly\Wp\Services\Application\Credit;

use Tokenly\Wp\Services\Service;
use Tokenly\Wp\Interfaces\Services\Application\Credit\VendorServiceInterface;

use Tokenly\Wp\Models\Credit\TransactionReport;
use Tokenly\Wp\Interfaces\Models\Credit\TransactionReportInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

class VendorService extends Service implements VendorServiceInterface {
	public function __construct(
		AccountRepositoryInterface $account_repository,
		TransactionRepositoryInterface $transaction_repository,
		TokenpassAPIInterface $client
	) {
		$this->account_repository = $account_repository;
		$this->transaction_repository = $transaction_repository;
		$this->client = $client;
	}

	/**
	 * Makes a credit transaction (app credits) for the user
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param array $parameters Transaction parameters
	 * @return TransactionReportInterface
	 */
	public function credit( string $group_uuid, string $account, float $amount, string $ref = null, string $source = null ): TransactionReportInterface {
		$this->ensure_account_exists( $group_uuid, $account );
		$this->ensure_account_exists( $group_uuid, $source );
		$transactions = $this->client->giveAppCredit( $group_uuid, $account, $amount, null, $source );
		$transactions = ( new TransactionReport() )->from_array( $transactions );
		return $transactions;
	}

	/**
	 * Makes a debit transaction (app credits) for the user
	 * @param OauthUserInterface $oauth_user Target OAuth User
	 * @param array $parameters Transaction parameters
	 * @return TransactionReportInterface
	 */
	public function debit( string $group_uuid, string $account, float $amount, string $ref = null, string $destination = null ): TransactionReportInterface {
		$this->ensure_account_exists( $group_uuid, $account );
		$this->ensure_account_exists( $group_uuid, $destination );
		$transactions = $this->client->takeAppCredit( $group_uuid, $account, $amount, null, $destination );
		$transactions = ( new TransactionReport() )->from_array( $transactions );
		return $transactions;
	}

	/**
	 * Checks if the user has an existing credit account and if not creates a new one
	 * for the specified credit group
	 * @param string name $name Account name
	 * @param string $group_id Index of the token group
	 * @return void
	 */
	protected function ensure_account_exists( string $group_uuid, string $name = null ): void {
		if ( !$name ) {
			return;
		}
		$account = $this->account_repository->show( array(
			'account_uuid' => $name,
			'group_uuid'   => $group_uuid,
		) );
		if ( !$account ){
			$account = $this->account_repository->store( array(
				'account_uuid' => $name,
				'group_uuid'   => $group_uuid,
			) );
		}
	}
}
