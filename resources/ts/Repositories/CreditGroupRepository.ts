import { injectable, inject } from 'inversify';
import { CreditGroupRepositoryInterface } from './../Interfaces/Repositories/CreditGroupRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class CreditGroupRepository implements CreditGroupRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index(): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupIndex().then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	store( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	update( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
