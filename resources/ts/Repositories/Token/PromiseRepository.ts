import PromiseRepositoryInterface from '../../Interfaces/Repositories/Token/PromiseRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';
import {
	ApiServiceInterface,
	TokenPromiseIndexParamsInterface,
	TokenPromiseShowParamsInterface,
	TokenPromiseStoreParamsInterface,
	TokenPromiseUpdateParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface';
import TokenPromiseInterface from '../../Interfaces/Models/Token/PromiseInterface';
import TokenPromise from '../../Models/Token/Promise';

@injectable()
export default class PromiseRepository implements PromiseRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: TokenPromiseIndexParamsInterface ): Promise<Array<TokenPromiseInterface>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenPromiseIndex( params ).then( ( result: any ) => {
				result = result.map( ( promise: any ) => {
					return ( new TokenPromise() ).fromJson( promise );
				} );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
	
	public show( id: number, params?: TokenPromiseShowParamsInterface ): Promise<TokenPromiseInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenPromiseShow( id, params ).then( ( result: any ) => {
				result = ( new TokenPromise() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: TokenPromiseStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenPromiseStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public update( id: number, params: TokenPromiseUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenPromiseUpdate( id, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public destroy( id: number ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenPromiseDestroy( id ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
