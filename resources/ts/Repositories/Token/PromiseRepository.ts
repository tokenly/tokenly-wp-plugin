import { injectable, inject } from 'inversify';
import { PromiseStoreParams, PromiseUpdateParams, PromiseData } from '../../Interfaces';
import PromiseRepositoryInterface from '../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import AdminApiServiceInterface from '../../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../../Types';

@injectable()
export default class PromiseRepository implements PromiseRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index( params: any = {} ): Promise<Array<PromiseData>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenPromiseIndex( params ).then( ( result: Array<PromiseData> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
	
	show( id: number, params?: any ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenPromiseShow( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	store( params: PromiseStoreParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenPromiseStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	update( id: number, params: PromiseUpdateParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenPromiseUpdate( id, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	destroy( id: number ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenPromiseDestroy( id ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
