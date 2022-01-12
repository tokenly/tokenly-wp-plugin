import { injectable, inject } from 'inversify';
import AddressRepositoryInterface from '../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import AdminApiServiceInterface from '../../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../../Types';

@injectable()
export default class AddressRepository implements AddressRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index( params?: any ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenAddressIndex( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	show( id: string, params: any = {} ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenAddressShow( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	balanceIndex( id: string, params: any = {} ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenAddressBalanceIndex( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
