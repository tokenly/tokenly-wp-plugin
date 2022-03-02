import VendorServiceInterface from '../../../Interfaces/Services/Application/Credit/VendorServiceInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../../Types';

import {
	ApiServiceInterface,
	CreditVendorDebitParamsInterface,
	CreditVendorCreditParamsInterface,
} from '../../../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class VendorService implements VendorServiceInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public debit( params?: CreditVendorDebitParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditVendorDebit( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public credit( params?: CreditVendorCreditParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditVendorCredit( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
