import { injectable, inject } from "inversify";
import { AdminApiService } from '../services/AdminApiService';
import { SourceData } from '../interfaces';

@injectable()
export class SourceRepository {
	adminApiService;
	
	constructor(
		@inject( AdminApiService ) adminApiService: AdminApiService
	) {
		this.adminApiService = adminApiService;
	}

	index() {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.sourceIndex().then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	store( params: SourceData ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.sourceStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
