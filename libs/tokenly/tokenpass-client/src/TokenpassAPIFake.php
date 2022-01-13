<?php
namespace Tokenly\TokenpassClient;
use Tokenly\TokenpassClient\TokenpassAPIInterfaceInterface;

class TokenpassAPIFake implements TokenpassAPIInterface
{
    public function checkTokenAccess($username, $rules, $oauth_token)
    {
        //
    }

    public function checkTokenAccessByEmail($email, $rules)
    {
        //
    }

    public function getPublicAddresses($username, $refresh=false)
    {
        //
    }

    public function getAddressesForAuthenticatedUser($oauth_token, $refresh = false)
    {
        //
    }

    public function getAddresses($username = false, $oauth_token = false, $refresh = false) {
		//
    }

    public function checkAddressTokenAccess($address, $rules = array())
    {
        //
    }

    public function updateAccount($user_id, $token, $password, $data = array())
    {
        //
    }

    public function registerAccount($username, $password, $email, $name = '')
    {
        //
    }
    public function verifyLoginCredentials($username, $password) {
        //
    }

    public function getOAuthAccessTokenWithCredentials($username, $password, $scopes)
    {
        //
    }

    public function getOAuthAccessToken($code)
    {
        //
    }
    public function getOAuthUserFromAccessToken($access_token)
    {
        //
    }

    public function getPublicAddressDetails($username, $address)
    {
        //
    }

    public function getAddressDetailsForAuthenticatedUser($address, $oauth_token)
    {
        //
    }

    public function registerAddress($address, $oauth_token, $label = '', $public = false, $active = true, $type = 'bitcoin')
    {
        //
    }

    public function verifyAddress($address, $oauth_token, $signature)
    {
       //
    }

    public function updateAddressDetails($address, $oauth_token, $label = null, $public = null, $active = null)
    {
        //
    }

    public function deleteAddress($address, $oauth_token)
    {
        //
    }

    public function lookupUserByAddress($address)
    {
        //
    }

    public function lookupAddressByUser($username)
    {
        //
    }

    public function registerProvisionalSource($address, $chain = 'bitcoin', $proof = null, $assets = null, $extra_opts = array())
    {
		//
    }

    public function getProvisionalSourceList()
    {
		//
    }

    public function getProvisionalSourceProofSuffix()
    {
        //
    }

    public function getProvisionalSourceProofMessage($address)
    {
        //
    }

    public function deleteProvisionalSource($address)
    {
        //
    }
	
    public function promiseTransaction($source, $destination, $asset, $quantity, $expiration, $txid = null, $fingerprint = null, $ref = null, $chain = 'bitcoin', $protocol = 'counterparty', $pseudo = false, $note = null)
    {
        //
    }

    public function getPromisedTransaction($id)
    {
        //
    }

    public function getPromisedTransactionList($destination = null)
    {
        //
    }

    public function getPromisedTransactionListByEmailAddress($email)
    {
        //
    }

    public function deletePromisedTransaction($id)
    {
        //
    }

    public function updatePromisedTransaction($id, $data)
    {
        //
    }

    public function getCombinedPublicBalances($oauth_token, $refresh = false)
    {
        //
    }

    public function getCombinedProtectedBalances($oauth_token, $refresh = false)
    {
        //
    }

    public function getChats($oauth_token)
    {
        //
    }

    public function joinChat($oauth_token, $chat_id)
    {
        //
    }

    public function getChat($oauth_token, $chat_uuid)
    {
        //
    }

    public function createChat($oauth_token, $create_vars)
    {
        //
    }

    public function editChat($oauth_token, $chat_uuid, $update_vars)
    {
        //
    }

    public function getChatPrivileges($oauth_token, $chat_id)
    {
        //
    }

    public function checkUserExists($username, $assign_user_hash=null, $strict=false)
    {
        //
    }

    public function newAppCreditGroup($name, $app_whitelist = array())
    {
        //
    }

    public function updateAppCreditGroup($id, $data)
    {
        //
    }

    public function listAppCreditGroups()
    {
        //
    }

    public function getAppCreditGroup($groupId)
    {
        //
    }

    public function newAppCreditAccount($groupId, $name)
    {
        //
    }

    public function listAppCreditAccounts($groupId)
    {
        //
    }

    public function getAppCreditAccount($groupId, $accountId)
    {
        //
    }

    public function getAppCreditAccountBalance($groupId, $accountId)
    {
        //
    }

    public function giveAppCredit($groupId, $account, $amount, $ref = null, $source = null)
    {
        //
    }

    public function takeAppCredit($groupId, $account, $amount, $ref = null, $destination = null)
    {
        //
    }

    public function giveMultipleAppCredit($groupId, $accounts_amounts)
    {
        //
    }

    public function takeMultipleAppCredit($groupId, $accounts_amounts)
    {
        //
    }

    public function creditMultipleAppCredit($groupId, $accounts_amounts)
    {
        //alias
        return $this->giveMultipleAppCredit($groupId, $accounts_amounts);
    }

    public function debitMultipleAppCredit($groupId, $accounts_amounts)
    {
        //alias
        return $this->takeMultipleAppCredit($groupId, $accounts_amounts);
    }

    public function getAppCreditGroupHistory($groupId)
    {
       //
    }

    public function getAppCreditAccountHistory($groupId, $account)
    {
        //
    }

    public function getUserByToken($token)
    {
		//
    }

    public function getUserByExistingToken($token) {
        //
    }

    public function getTokenPerks($token) {
        //
    }

    public function lookupUserByEmail($email)
    {
        //
    }
}
