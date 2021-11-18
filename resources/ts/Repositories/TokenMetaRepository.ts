import { injectable, inject } from 'inversify';
import { TokenMetaData } from '../Interfaces';
import { TokenMetaRepositoryInterface } from './../Interfaces/Repositories/TokenMetaRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class TokenMetaRepository implements TokenMetaRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	show( postId: number ): Promise<TokenMetaData> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenMetaShow( postId ).then( ( result: TokenMetaData ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( postId: number, params: TokenMetaData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenMetaUpdate( postId, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
