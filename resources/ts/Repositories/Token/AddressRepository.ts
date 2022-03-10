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
import AddressCollection from '../../Collections/Token/AddressCollection';
import AddressInterface from '../../Interfaces/Models/Token/AddressInterface';
import AddressCollectionInterface from '../../Interfaces/Collections/Token/AddressCollectionInterface';
import BalanceCollectionInterface from '../../Interfaces/Collections/Token/BalanceCollectionInterface';
import BalanceCollection from '../../Collections/Token/BalanceCollection';

@injectable()
export default class AddressRepository implements AddressRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: TokenAddressIndexParamsInterface ): Promise<AddressCollectionInterface> {
		return new Promise<AddressCollectionInterface>( ( resolve, reject ) => {
			this.ApiService.tokenAddressIndex( params ).then( ( result: any ) => {
				result = ( new AddressCollection() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public show( id: string, params?: TokenAddressShowParamsInterface ): Promise<AddressInterface> {
		return new Promise<AddressInterface>( ( resolve, reject ) => {
			this.ApiService.tokenAddressShow( id, params ).then( ( result: any ) => {
				result = ( new Address() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: TokenAddressStoreParamsInterface ): Promise<Array<any>> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenAddressStore( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public update( id: string, params: TokenAddressUpdateParamsInterface ): Promise<Array<any>> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenAddressUpdate( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public destroy( id: string ): Promise<Array<any>> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenAddressDestroy( id ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public verify( id: string, params: TokenAddressVerifyParamsInterface ): Promise<Array<any>> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenAddressVerify( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public balanceIndex( id: string, params?: TokenAddressBalanceIndexParamsInterface ): Promise<BalanceCollectionInterface> {
		return new Promise<BalanceCollectionInterface>( ( resolve, reject ) => {
			this.ApiService.tokenAddressBalanceIndex( id, params ).then( ( result: any ) => {
				result = ( new BalanceCollection() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
