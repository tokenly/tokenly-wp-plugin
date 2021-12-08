import { injectable, inject } from 'inversify';
import { CreditTransactionRepositoryInterface } from './../Interfaces/Repositories/CreditTransactionRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class CreditTransactionRepository implements CreditTransactionRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index(): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditTransactionIndex().then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	store( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditTransactionStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
