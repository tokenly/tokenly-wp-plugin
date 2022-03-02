export interface ApiServiceInterface {
	creditGroupAccountIndex( uuid: string, params?: CreditGroupAccountIndexParamsInterface ): Promise<Array<any>>;
	creditGroupIndex( params?: CreditGroupIndexParamsInterface ): Promise<Array<any>>;
	creditGroupShow( uuid: string, params?: CreditGroupShowParamsInterface ): Promise<Array<any>>;
	creditGroupStore( params: CreditGroupStoreParamsInterface ): Promise<any>;
	creditGroupUpdate( uuid: string, params: CreditGroupUpdateParamsInterface ): Promise<any>;
	creditGroupWhitelistUpdate( params: CreditGroupWhitelistUpdateParamsInterface ): Promise<any>;
	creditTransactionIndex( params?: CreditTransactionIndexParamsInterface ): Promise<Array<any>>;
	creditTransactionStore( params: CreditTransactionStoreParamsInterface ): Promise<any>;
	creditVendorDebit( params: CreditVendorDebitParamsInterface ): Promise<any>;
	creditVendorCredit( params: CreditVendorCreditParamsInterface ): Promise<any>;
	settingsShow( type: string ): Promise<any>;
	settingsUpdate( type: string, params: SettingsUpdateParamsInterface ): Promise<any>;
	tokenAddressIndex( params: TokenAddressIndexParamsInterface ): Promise<Array<any>>;
	tokenAddressShow( id: string, params?: TokenAddressShowParamsInterface ): Promise<Array<any>>;
	tokenAddressStore( params?: TokenAddressStoreParamsInterface ): Promise<Array<any>>;
	tokenAddressUpdate( id: string, params?: TokenAddressUpdateParamsInterface ): Promise<Array<any>>;
	tokenAddressDestroy( id: string ): Promise<Array<any>>;
	tokenAddressVerify( id: string, params?: TokenAddressVerifyParamsInterface ): Promise<Array<any>>;
	tokenAddressBalanceIndex( id: string, params: TokenAddressBalanceIndexParamsInterface ): Promise<Array<any>>;
	tokenSourceIndex( params?: TokenSourceIndexParamsInterface ): Promise<Array<any>>;
	tokenSourceShow( id: string, params?: TokenSourceShowParamsInterface ): Promise<Array<any>>;
	tokenSourceStore( params: TokenSourceStoreParamsInterface ): Promise<any>;
	tokenSourceUpdate( address: string, params: TokenSourceUpdateParamsInterface ): Promise<any>;
	tokenSourceDestroy( address: string ): Promise<any>;
	tokenPromiseIndex( params: TokenPromiseIndexParamsInterface ): Promise<Array<any>>;
	tokenPromiseShow( id: number, params?: TokenPromiseShowParamsInterface ): Promise<Array<any>>;
	tokenPromiseStore( params: TokenPromiseStoreParamsInterface ): Promise<any>;
	tokenPromiseUpdate( promiseId: number, params: TokenPromiseUpdateParamsInterface ): Promise<any>;
	tokenPromiseDestroy( promiseId: number ): Promise<any>;
	tokenVendorPromise( params: TokenVendorPromiseParamsInterface ): Promise<any>;
	tokenWhitelistUpdate( params: TokenWhitelistUpdateParamsInterface ): Promise<any>;
	userIndex( params: UserIndexParamsInterface ): Promise<any>;
	userShow( id: string, params?: UserShowParamsInterface ): Promise<any>;
	userCreditBalanceIndex( id: string, params?: UserCreditBalanceIndexParamsInterface ): Promise<any>;
	userCreditBalanceShow( id: string, group: string ): Promise<any>;
	userTokenAddressIndex( id: string, params?: UserTokenAddressIndexParamsInterface ): Promise<any>;
	userTokenAddressShow( id: string, address: string, params?: UserTokenAddressShowParamsInterface ): Promise<any>;
	userTokenBalanceIndex( id: string, params?: UserTokenBalanceIndexParamsInterface ): Promise<any>;
	userTokenBalanceShow( id: string, asset: string ): Promise<any>;
	authGetStatus(): Promise<any>;
	authConnect(): Promise<any>;
	authDisconnect(): Promise<any>;
}

export interface CreditGroupAccountIndexParamsInterface {
	//
}

export interface CreditGroupIndexParamsInterface {
	//
}

export interface CreditGroupShowParamsInterface {
	//
}

export interface CreditGroupStoreParamsInterface {
	//
}

export interface CreditGroupUpdateParamsInterface {
	//
}

export interface CreditGroupWhitelistUpdateParamsInterface {
	//
}

export interface CreditTransactionIndexParamsInterface {
	//
}

export interface CreditTransactionStoreParamsInterface {
	//
}

export interface CreditVendorDebitParamsInterface {
	//
}

export interface CreditVendorCreditParamsInterface {
	//
}

export interface TokenAddressIndexParamsInterface {
	//
}

export interface TokenAddressBalanceIndexParamsInterface {
	//
}

export interface TokenAddressShowParamsInterface {
	//
}

export interface TokenAddressStoreParamsInterface {
	address: string;
	label: string;
	public: boolean;
	type: string;
}

export interface TokenAddressUpdateParamsInterface {
	address?: string,
	label?: string,
	public?: boolean,
	active?: boolean,
	type?: string,
}

export interface TokenAddressVerifyParamsInterface {
	signature: string;
}

export interface TokenPromiseIndexParamsInterface {
	//
}

export interface TokenPromiseShowParamsInterface {
	//
}

export interface TokenPromiseStoreParamsInterface {
	//
}

export interface TokenPromiseUpdateParamsInterface {
	quantity?: any;
	expiration?: string;
	txid?: string;
	fingerprint?: string;
	ref?: string;
	note?: string;
}

export interface TokenSourceIndexParamsInterface {
	//
}

export interface TokenSourceShowParamsInterface {
	//
}

export interface TokenSourceStoreParamsInterface {
	//
}

export interface TokenSourceUpdateParamsInterface {
	//
}

export interface TokenVendorPromiseParamsInterface {
	//
}

export interface TokenWhitelistUpdateParamsInterface {
	//
}

export interface UserIndexParamsInterface {
	//
}

export interface UserShowParamsInterface {
	//
}

export interface UserCreditBalanceIndexParamsInterface {
	//
}

export interface UserTokenAddressIndexParamsInterface {
	//
}

export interface UserTokenAddressShowParamsInterface {
	//
}

export interface UserTokenBalanceIndexParamsInterface {
	//
}

export interface SettingsUpdateParamsInterface {
	//
}
