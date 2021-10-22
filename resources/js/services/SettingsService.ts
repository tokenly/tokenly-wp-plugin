declare const wpApiSettings: any;

export interface SettingsData {
	client_id: string;
	client_secret: string;
}

export class SettingsService {
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
	
	getSettings() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const url = this.namespace + 'settings';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: SettingsData ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
	
	updateSettings( newSettings: SettingsData ) {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'PUT',
				headers: this.headers,
				body: JSON.stringify( {
					settings: {
						...{ client_id: newSettings.client_id ?? '' },
						...{ client_secret: newSettings.client_secret ?? '' },
					}
				} ),
			}
			const url = this.namespace + 'settings';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: SettingsData ) => {
					resolve( data )
				} )
				.catch( err => reject( err ) );
			} );
	}
}