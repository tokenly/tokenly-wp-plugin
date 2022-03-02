import TransactionRepositoryInterface from '../../Interfaces/Repositories/Credit/TransactionRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';

import {
	ApiServiceInterface,
	CreditTransactionIndexParamsInterface,
	CreditTransactionStoreParamsInterface,
} from './../../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class TransactionRepository implements TransactionRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: CreditTransactionIndexParamsInterface ): Promise<Array<any>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditTransactionIndex( params ).then( ( result: Array<any> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: CreditTransactionStoreParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditTransactionStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
