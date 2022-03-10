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
import TransactionCollectionInterface from '../../Interfaces/Collections/Credit/TransactionCollectionInterface';
import TransactionCollection from '../../Collections/Credit/TransactionCollection';

@injectable()
export default class TransactionRepository implements TransactionRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	public index( params?: CreditTransactionIndexParamsInterface ): Promise<TransactionCollectionInterface> {
		return new Promise<TransactionCollectionInterface>( ( resolve, reject ) => {
			this.ApiService.creditTransactionIndex( params ).then( ( result: any ) => {
				result = ( new TransactionCollection() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}

	public store( params: CreditTransactionStoreParamsInterface ): Promise<TransactionInterface> {
		return new Promise<TransactionInterface>( ( resolve, reject ) => {
			this.ApiService.creditTransactionStore( params ).then( result => {
				result = ( new Transaction() ).fromJson( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
