import { injectable, inject } from 'inversify';
import BalanceRepositoryInterface from '../../Interfaces/Repositories/Token/BalanceRepositoryInterface';
import AdminApiServiceInterface from '../../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../../Types';

@injectable()
export default class BalanceRepository implements BalanceRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index( params: any = {} ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenBalanceIndex( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
