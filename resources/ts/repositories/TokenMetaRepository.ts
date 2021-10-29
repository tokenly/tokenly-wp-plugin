import { injectable, inject } from "inversify";
import { AdminApiService } from '../services/AdminApiService';

export interface TokenMetaData {
	asset: string;
}

@injectable()
export class TokenMetaRepository {
	AdminApiService;
	
	constructor(
		@inject( AdminApiService ) AdminApiService: AdminApiService
	) {
		this.AdminApiService = AdminApiService;
	}
	
	show( postId: number ) {
		return new Promise<TokenMetaData>( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.AdminApiService.headers,
			}
			const url = this.AdminApiService.namespace + 'whitelist' + '/' + postId;
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: TokenMetaData ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	// update( newWhitelist: WhitelistData ) {
	// 	return new Promise( ( resolve, reject ) => {
	// 	const body = JSON.stringify({
	// 		settings: {
	// 			...( newWhitelist.use_whitelist ) && { use_whitelist: newWhitelist.use_whitelist },
	// 			...( newWhitelist.whitelist ) && { whitelist: newWhitelist.whitelist },
	// 		}
	// 	});
	// 	const params = {
	// 		method: 'PUT',
	// 		headers: this.headers,
	// 		body: body,
	// 	 }
	// 	 const url = this.namespace + 'whitelist';
	// 	 fetch( url, params )
	// 		.then( response => response.json() )
	// 		.then( data => {
	// 			resolve( data );
	// 		})
	// 		.catch( err => reject( err ) );
	// 	} );
	// }
}
