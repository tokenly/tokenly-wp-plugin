import { injectable, inject } from 'inversify';
import { TokenMetaData } from '../../Interfaces';
import MetaRepositoryInterface from '../../Interfaces/Repositories/Token/MetaRepositoryInterface';
import AdminApiServiceInterface from '../../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../../Types';

@injectable()
export default class MetaRepository implements MetaRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
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
