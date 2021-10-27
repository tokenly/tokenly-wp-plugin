import { injectable } from "inversify";

declare const wpApiSettings: any;

export interface SourceData {
	//
}

export interface SourceStoreData {
	address: string,
	assets: string,
}

@injectable()
export class SourceRepository {
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
	
	store( sourceData: SourceStoreData ) {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'POST',
				headers: this.headers,
				body: JSON.stringify( {
					source_data: sourceData,
				} ),
			}
			const url = this.namespace + 'source';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: any ) => {
					console.log(data);
					resolve( data )
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	index() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: this.headers,
			}
			const url = this.namespace + 'source';
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data: any ) => {
					console.log(data);
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
}
