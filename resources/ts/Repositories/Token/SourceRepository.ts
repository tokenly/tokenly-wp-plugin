import SourceRepositoryInterface from '../../Interfaces/Repositories/Token/SourceRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';

import {
	ApiServiceInterface,
	TokenSourceIndexParamsInterface,
	TokenSourceShowParamsInterface,
	TokenSourceStoreParamsInterface,
	TokenSourceUpdateParamsInterface,
} from './../../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class SourceRepository implements SourceRepositoryInterface {
	ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: TokenSourceIndexParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenSourceIndex( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	public show( id: string, params?: TokenSourceShowParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenSourceShow( id, params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: TokenSourceStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenSourceStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public update( address: string, params: TokenSourceUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenSourceUpdate( address, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public destroy( address: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenSourceDestroy( address ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
