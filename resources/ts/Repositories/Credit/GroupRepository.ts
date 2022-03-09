import GroupRepositoryInterface from '../../Interfaces/Repositories/Credit/GroupRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';

import {
	ApiServiceInterface,
	CreditGroupAccountIndexParamsInterface,
	CreditGroupIndexParamsInterface,
	CreditGroupShowParamsInterface,
	CreditGroupStoreParamsInterface,
	CreditGroupUpdateParamsInterface,
	CreditGroupWhitelistUpdateParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface';
import GroupInterface from '../../Interfaces/Models/Credit/GroupInterface';
import Group from '../../Models/Credit/Group';

@injectable()
export default class GroupRepository implements GroupRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: CreditGroupIndexParamsInterface ): Promise<Array<GroupInterface>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditGroupIndex( params ).then( ( result: any ) => {
				result = result.map( ( group: any ) => {
					return ( new Group() ).fromJson( group );
				} )
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public show( uuid: string, params?: CreditGroupShowParamsInterface ): Promise<GroupInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditGroupShow( uuid, params ).then( ( result: any ) => {
				result = ( new Group() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: CreditGroupStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditGroupStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public update( uuid: string, params: CreditGroupUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditGroupUpdate( uuid, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public accountIndex( uuid: string, params?: CreditGroupAccountIndexParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditGroupAccountIndex( uuid, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public whitelistUpdate( params: CreditGroupWhitelistUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditGroupWhitelistUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
