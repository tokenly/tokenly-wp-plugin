import { injectable } from "inversify";

declare const wpApiSettings: any;

export interface VendorData {
	//
}

@injectable()
export class VendorRepository {
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
	
	create() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'POST',
				headers: this.headers,
				body: JSON.stringify( {
					settings: {
						//
					}
				} ),
			}
			const url = this.namespace + 'vendor';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: VendorData ) => {
					resolve( data )
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	read() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const url = this.namespace + 'vendor';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: VendorData ) => {
					console.log(data);
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
	
	update( newSettings: VendorData ) {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'PUT',
				headers: this.headers,
				body: JSON.stringify( {
					settings: {
						//
					}
				} ),
			}
			const url = this.namespace + 'vendor';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: VendorData ) => {
					resolve( data )
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	delete() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'DELETE',
				headers: this.headers,
				body: JSON.stringify( {
					settings: {
						//
					}
				} ),
			}
			const url = this.namespace + 'vendor';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: VendorData ) => {
					resolve( data )
				} )
				.catch( err => reject( err ) );
		} );
	}
}