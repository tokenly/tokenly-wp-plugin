import { injectable, inject } from 'inversify';
import { AdminApiService } from '../services/AdminApiService';
import { PromiseStoreParams, PromiseUpdateParams, PromiseData } from '../Interfaces';

@injectable()
export class PromiseRepository {
	adminApiService;
	
	constructor(
		@inject( AdminApiService ) adminApiService: AdminApiService
	) {
		this.adminApiService = adminApiService;
	}

	index() {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseIndex().then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
	
	store( params: PromiseStoreParams ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	update( promiseId: number, params: PromiseUpdateParams ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseUpdate( promiseId, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	destroy( promiseId: number ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.promiseDestroy( promiseId ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
