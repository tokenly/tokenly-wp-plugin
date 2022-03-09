import TransactionRepositoryInterface from '../../Interfaces/Repositories/Credit/TransactionRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../../Types';
import {
	ApiServiceInterface,
	CreditTransactionIndexParamsInterface,
	CreditTransactionStoreParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface';
import TransactionInterface from '../../Interfaces/Models/Credit/TransactionInterface';
import Transaction from '../../Models/Credit/Transaction';

@injectable()
export default class TransactionRepository implements TransactionRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: CreditTransactionIndexParamsInterface ): Promise<Array<TransactionInterface>> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.creditTransactionIndex( params ).then( ( result: any ) => {
				result = result.map( ( transaction: any ) => {
					return ( new Transaction() ).fromJson( transaction );
				} )
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
