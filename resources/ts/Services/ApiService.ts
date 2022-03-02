import { injectable, inject } from 'inversify';
import { TYPES } from '../Types';

import {
	ApiServiceInterface,
	CreditGroupAccountIndexParamsInterface,
	CreditGroupIndexParamsInterface,
	CreditGroupShowParamsInterface,
	CreditGroupStoreParamsInterface,
	CreditGroupUpdateParamsInterface,
	CreditGroupWhitelistUpdateParamsInterface,
	CreditTransactionIndexParamsInterface,
	CreditTransactionStoreParamsInterface,
	CreditVendorDebitParamsInterface,
	CreditVendorCreditParamsInterface,
	TokenAddressIndexParamsInterface,
	TokenAddressBalanceIndexParamsInterface,
	TokenAddressShowParamsInterface,
	TokenAddressStoreParamsInterface,
	TokenAddressUpdateParamsInterface,
	TokenAddressVerifyParamsInterface,
	TokenPromiseIndexParamsInterface,
	TokenPromiseShowParamsInterface,
	TokenPromiseStoreParamsInterface,
	TokenPromiseUpdateParamsInterface,
	TokenSourceIndexParamsInterface,
	TokenSourceShowParamsInterface,
	TokenSourceStoreParamsInterface,
	TokenSourceUpdateParamsInterface,
	TokenVendorPromiseParamsInterface,
	TokenWhitelistUpdateParamsInterface,
	UserIndexParamsInterface,
	UserShowParamsInterface,
	UserCreditBalanceIndexParamsInterface,
	UserTokenAddressIndexParamsInterface,
	UserTokenAddressShowParamsInterface,
	UserTokenBalanceIndexParamsInterface,
	SettingsUpdateParamsInterface
} from './../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class ApiService implements ApiServiceInterface {
	protected namespace: string;
	protected nonce: string;
	protected headers: any;

	public constructor(
		@inject( TYPES.Variables.namespace ) namespace: string,
		@inject( TYPES.Variables.nonce ) nonce: string
	) {
		this.namespace = namespace;
		this.nonce = nonce;
		this.headers = {
			'Content-type': 'application/json; charset=UTF-8',
			'X-WP-Nonce': this.nonce,
		}
	}
	
	public settingsShow( type: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/settings/${type}` ).then( ( result: any ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public settingsUpdate( type: string, params: SettingsUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/settings/${type}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditGroupIndex( params?: CreditGroupIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/credit/group', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditGroupShow( uuid: string, params?: CreditGroupShowParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/credit/group/${uuid}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditGroupStore( params: CreditGroupStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/credit/group', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditGroupUpdate( uuid: string, params: CreditGroupUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/credit/group/${uuid}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditGroupWhitelistUpdate( params: CreditGroupWhitelistUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/credit/group-whitelist`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditGroupAccountIndex( uuid: string, params: CreditGroupAccountIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/credit/group/${uuid}/account`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditTransactionIndex( params?: CreditTransactionIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/credit/transaction', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditTransactionStore( params: CreditTransactionStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/credit/transaction', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditVendorDebit( params: CreditVendorDebitParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/credit/vendor/debit', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditVendorCredit( params: CreditVendorCreditParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/credit/vendor/credit', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressIndex( params?: TokenAddressIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/address', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressShow( id: string, params?: TokenAddressShowParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/address/${id}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressStore( params: TokenAddressStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', `/token/address`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressUpdate( id: string, params: TokenAddressUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/address/${id}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressDestroy( id: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'DELETE', `/token/address/${id}` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressVerify( id: string, params: TokenAddressVerifyParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/address/${id}/verify`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressBalanceIndex( id: string, params?: TokenAddressBalanceIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/address/${id}/balance`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenPromiseIndex( params?: TokenPromiseIndexParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/promise', params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenPromiseShow( id: number, params?: TokenPromiseShowParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/promise/${id}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenPromiseStore( params: TokenPromiseStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/token/promise', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenPromiseUpdate( promiseId: number, params: TokenPromiseUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/promise/${promiseId}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenPromiseDestroy( promiseId: number ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'DELETE', `/token/promise/${promiseId}` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenSourceIndex( params?: TokenSourceIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/source', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenSourceShow( id: string, params?: TokenSourceShowParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/source/${id}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenSourceStore( params: TokenSourceStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/token/source', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenSourceUpdate( address: string, params: TokenSourceUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/source/${address}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenSourceDestroy( address: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'DELETE', `/token/source/${address}` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenVendorPromise( params: TokenVendorPromiseParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/token/vendor/promise', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenWhitelistUpdate( params?: TokenWhitelistUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/whitelist`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userIndex( params?: UserIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/user', params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userShow( id: string, params?: UserShowParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userCreditBalanceIndex( id: string, params?: UserCreditBalanceIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/credit/balance`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userCreditBalanceShow( id: string, group: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/credit/balance/${group}` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userTokenAddressIndex( id: string, params?: UserTokenAddressIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/token/address`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userTokenAddressShow( id: string, address: string, params?: UserTokenAddressShowParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/token/address/${address}`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userTokenBalanceIndex( id: string, params?: UserTokenBalanceIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/token/balance`, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public userTokenBalanceShow( id: string, asset: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/token/balance/${asset}` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public authGetStatus(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/authorize` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public authConnect(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', `/authorize` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public authDisconnect(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'DELETE', `/authorize` ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	protected makeRequest( method: string = '', route: string = '', args: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			const controller = new AbortController();
			const signal = controller.signal;
			window.addEventListener( 'beforeunload', ( event ) => {
				controller.abort();
			} );
			const params: RequestInit = {
				method: method,
				signal: signal,
				headers: this.headers,
			};
			const withBody = ['POST', 'PUT', 'UPDATE'];
			let url = `/wp-json/${this.namespace}/v1${route}`;
			if ( withBody.includes( method ) ) {
				params.body = JSON.stringify( args );
			} else {
				const queryParams = new URLSearchParams( args as any );
				url = `${url}? + ${queryParams}`;
			}
			fetch( url, params )
				.then( response => {
					return response.text()
				} )
				.then( ( data ) => {
					resolve( data ? JSON.parse( data ) : null )
				} )
				.catch( ( error ) => {
					reject( error )
				} )
		} );
	}
}
