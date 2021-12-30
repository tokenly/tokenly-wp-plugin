import { injectable, inject } from 'inversify';
import { UserIndexParams, UserShowParams } from '../Interfaces';
import UserRepositoryInterface from './../Interfaces/Repositories/UserRepositoryInterface';
import AdminApiServiceInterface from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export default class UserRepository implements UserRepositoryInterface {
	adminApiService;

	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	index( params: UserIndexParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.userIndex( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	show( userId: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.userShow( userId, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
