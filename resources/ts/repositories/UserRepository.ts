import { injectable, inject } from "inversify";
import { UserIndexParams, UserShowParams } from '../interfaces';
import { AdminApiService } from '../services/AdminApiService';

@injectable()
export class UserRepository {
	adminApiService;

	constructor(
		@inject( AdminApiService ) adminApiService: AdminApiService
	) {
		this.adminApiService = adminApiService;
	}
	
	index( params: UserIndexParams ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.userIndex( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	show( userId: number, params: UserShowParams ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.userShow( userId, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
