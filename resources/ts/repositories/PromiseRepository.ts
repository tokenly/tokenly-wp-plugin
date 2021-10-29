import { injectable, inject } from "inversify";
import { AdminApiService } from '../services/AdminApiService';
import { PromiseStoreParams } from '../interfaces';

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
}
