import { injectable } from "inversify";

declare const wpApiSettings: any;

interface AuthData {
	status: boolean,
}

@injectable()
export class AuthService {
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
	
	getStatus() {
		return new Promise<AuthData>( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const url = this.namespace + 'authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: AuthData ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	connect() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'POST',
				headers: this.headers,
			}
			const url = this.namespace + 'authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					const redirectUrl = data.url ?? null;
					if ( redirectUrl ) {
						window.location = redirectUrl;
					}
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	disconnect() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'DELETE',
				headers: this.headers,
			}
			const url = this.namespace + 'authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					window.location.reload();
				} )
				.catch( err => reject( err ) );
		});
	}
}