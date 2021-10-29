import { injectable, inject } from "inversify";
import { AdminApiService } from '../services/AdminApiService';
import { TokenMetaData } from '../interfaces';

@injectable()
export class TokenMetaRepository {
	adminApiService;
	
	constructor(
		@inject( AdminApiService ) adminApiService: AdminApiService
	) {
		this.adminApiService = adminApiService;
	}
	
	show( postId: number ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenMetaShow( postId ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( postId: number, params: TokenMetaData ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenMetaUpdate( postId, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
