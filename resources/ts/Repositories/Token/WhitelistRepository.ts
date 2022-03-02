import WhitelistRepositoryInterface from '../../Interfaces/Repositories/Token/WhitelistRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';

import {
	ApiServiceInterface,
	TokenWhitelistUpdateParamsInterface,
} from './../../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class WhitelistRepository implements WhitelistRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public update( params: TokenWhitelistUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenWhitelistUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
