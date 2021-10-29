import { injectable } from "inversify";
import {
	SettingsData,
	WhitelistData,
	SourceData,
} from "../interfaces";

declare const wpApiSettings: any;

@injectable()
export class AdminApiService {
	namespace = '/wp-json/tokenly/v1';

	get headers() {
		return {
			'Content-type': 'application/json; charset=UTF-8',
			'X-WP-Nonce': wpApiSettings.nonce,
		}
	}
	
	settingsShow() {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/settings' ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	settingsUpdate( params: SettingsData ) {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', '/settings', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	sourceIndex() {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/source' ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	sourceStore( params: SourceData ) {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/source', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	whitelistShow() {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/whitelist' ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	whitelistUpdate( params: WhitelistData ) {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', '/whitelist', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	makeRequest( method: string = '', route: string = '', args: object = {} ) {
		return new Promise( ( resolve, reject ) => {
			const params: RequestInit = {
				method: method,
				headers: this.headers,
			};
			const withBody = ['POST', 'PUT', 'UPDATE'];
			let url = `${this.namespace}${route}`;
			if( withBody.includes( method ) ) {
				params.body = JSON.stringify( args );
			} else {
				const queryParams = new URLSearchParams( args as any );
				url = `${url}? + ${queryParams}`;
			}
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
}
