import { injectable } from "inversify";

declare const wpApiSettings: any;

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
	
	read() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const url = this.namespace + 'user';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data ) => {
					console.log(data);
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
}