import AddressRepositoryInterface from '../../Interfaces/Repositories/Token/AddressRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';
import {
	ApiServiceInterface,
	TokenAddressIndexParamsInterface,
	TokenAddressBalanceIndexParamsInterface,
	TokenAddressShowParamsInterface,
	TokenAddressStoreParamsInterface,
	TokenAddressUpdateParamsInterface,
	TokenAddressVerifyParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface';
import Address from '../../Models/Token/Address';
import AddressInterface from '../../Interfaces/Models/Token/AddressInterface';

@injectable()
export default class AddressRepository implements AddressRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: TokenAddressIndexParamsInterface ): Promise<Array<AddressInterface>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressIndex( params ).then( ( result: Array<AddressInterface> ) => {
				result = result.map( ( address: any ) => {
					return ( new Address() ).fromJson( address );
				} )
				console.log(result);
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public show( id: string, params?: TokenAddressShowParamsInterface ): Promise<AddressInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressShow( id, params ).then( ( result: any ) => {
				result = ( new Address() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: TokenAddressStoreParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressStore( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public update( id: string, params: TokenAddressUpdateParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressUpdate( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public destroy( id: string ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressDestroy( id ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public verify( id: string, params: TokenAddressVerifyParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressVerify( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public balanceIndex( id: string, params?: TokenAddressBalanceIndexParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenAddressBalanceIndex( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
