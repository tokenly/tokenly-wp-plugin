import { injectable, inject } from 'inversify';
import { WhitelistData } from '../Interfaces';
import { AdminApiService } from '../services/AdminApiService';

@injectable()
export class WhitelistRepository {
	adminApiService;

	constructor(
		@inject( AdminApiService ) adminApiService: AdminApiService
	) {
		this.adminApiService = adminApiService;
	}
	
	show() {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.whitelistShow().then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
	
	update( params: WhitelistData ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.whitelistUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
