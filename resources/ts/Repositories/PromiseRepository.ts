import { injectable, inject } from 'inversify';
import { PromiseStoreParams, PromiseUpdateParams, PromiseData } from '../Interfaces';
import { PromiseRepositoryInterface } from './../Interfaces/Repositories/PromiseRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class PromiseRepository implements PromiseRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index(): Promise<Array<PromiseData>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseIndex().then( ( result: Array<PromiseData> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
	
	store( params: PromiseStoreParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	update( promiseId: number, params: PromiseUpdateParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseUpdate( promiseId, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	destroy( promiseId: number ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseDestroy( promiseId ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
