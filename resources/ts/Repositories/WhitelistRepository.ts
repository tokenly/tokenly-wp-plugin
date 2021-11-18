import { injectable, inject } from 'inversify';
import { WhitelistData } from '../Interfaces';
import { WhitelistRepositoryInterface } from './../Interfaces/Repositories/WhitelistRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../Types';

@injectable()
export class WhitelistRepository implements WhitelistRepositoryInterface {
	adminApiService;

	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	show(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.whitelistShow().then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
	
	update( params: WhitelistData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.whitelistUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
