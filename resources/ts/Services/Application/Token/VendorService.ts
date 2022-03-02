import VendorServiceInterface from '../../../Interfaces/Services/Application/Token/VendorServiceInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../../Types';

import {
	ApiServiceInterface,
	TokenVendorPromiseParamsInterface,
} from '../../../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class VendorService implements VendorServiceInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public promise( params?: TokenVendorPromiseParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.tokenVendorPromise( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
