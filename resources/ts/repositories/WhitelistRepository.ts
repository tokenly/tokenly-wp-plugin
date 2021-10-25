import { injectable } from "inversify";

declare const wpApiSettings: any;

export interface WhitelistItem {
	address: string;
	index: string;
}

export interface WhitelistData {
	use_whitelist: boolean;
	whitelist: Array<WhitelistItem>;
}

@injectable()
export class WhitelistRepository {
	namespace = '/wp-json/tokenly/v1/';
	
	constructor() {
		//
	}
	
	get headers() {
		return {
			'Content-type': 'application/json; charset=UTF-8',
			'X-WP-Nonce': wpApiSettings.nonce,
		}
	}
	
	read() {
		return new Promise<WhitelistData>( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const url = this.namespace + 'whitelist';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: WhitelistData ) => {
					resolve( {
						... { use_whitelist: data.use_whitelist ?? false },
						...( data?.whitelist ) && { whitelist: data.whitelist },
					} );
					resolve( data );
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	update( newWhitelist: WhitelistData ) {
		return new Promise( ( resolve, reject ) => {
		const body = JSON.stringify({
			settings: {
				...( newWhitelist.use_whitelist ) && { use_whitelist: newWhitelist.use_whitelist },
				...( newWhitelist.whitelist ) && { whitelist: newWhitelist.whitelist },
			}
		});
		const params = {
			method: 'PUT',
			headers: this.headers,
			body: body,
		 }
		 const url = this.namespace + 'whitelist';
		 fetch( url, params )
			.then( response => response.json() )
			.then( data => {
				resolve( data );
			})
			.catch( err => reject( err ) );
		} );
	}
}