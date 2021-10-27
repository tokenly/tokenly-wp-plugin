import { injectable } from "inversify";

declare const wpApiSettings: any;

export interface UserSuggestion {
	id: number;
	name: string;
}

export interface UserShowParameters {
	id: number,
}

export interface UserIndexParameters {
	name: string,
}

@injectable()
export class UserRepository {
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
	
	index( indexParameters: UserIndexParameters ) {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const args = {
				index_parameters: JSON.stringify( indexParameters ),
			}
			const url = this.namespace + 'user?' + new URLSearchParams( args as any );
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}

	show( showParameters: UserShowParameters ) {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const args = {
				show_parameters: JSON.stringify( showParameters ),
			}
			const url = this.namespace + 'user/?' + new URLSearchParams( args as any );
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
}
