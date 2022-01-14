import { injectable, inject } from 'inversify';
import GroupRepositoryInterface from '../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import AdminApiServiceInterface from '../../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../../Types';

@injectable()
export default class GroupRepository implements GroupRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index( params: any = {} ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupIndex( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	show( uuid: string, params?: any ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupShow( uuid, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	store( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	update( uuid: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.creditGroupUpdate( uuid, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
