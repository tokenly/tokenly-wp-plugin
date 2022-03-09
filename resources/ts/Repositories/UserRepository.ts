import UserRepositoryInterface from '../Interfaces/Repositories/UserRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../Types';
import {
	ApiServiceInterface,
	UserIndexParamsInterface,
	UserShowParamsInterface,
	UserCreditBalanceIndexParamsInterface,
	UserTokenBalanceIndexParamsInterface,
	UserTokenAddressIndexParamsInterface,
} from '../Interfaces/Services/ApiServiceInterface';
import UserInterface from '../Interfaces/Models/UserInterface';
import User from '../Models/User';

@injectable()
export default class UserRepository implements UserRepositoryInterface {
	protected ApiService: ApiServiceInterface;

	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}
	
	public index( params?: UserIndexParamsInterface ): Promise<Array<UserInterface>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userIndex( params ).then( ( result: any ) => {
				result = result.map( ( user: any ) => {
					return ( new User() ).fromJson( user );
				} )
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public show( id: string, params?: UserShowParamsInterface ): Promise<UserInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userShow( id, params ).then( ( result: any ) => {
				result = ( new User() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditBalanceIndex( id: string, params: UserCreditBalanceIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userCreditBalanceIndex( id, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public creditBalanceShow( id: string, group: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userCreditBalanceShow( id, group ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenBalanceIndex( id: string, params?: UserTokenBalanceIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userTokenBalanceIndex( id, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenBalanceShow( id: string, asset: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userTokenBalanceShow( id, asset ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public tokenAddressIndex( id: string, params?: UserTokenAddressIndexParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userTokenAddressIndex( id, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
