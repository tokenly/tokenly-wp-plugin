import { injectable } from "inversify";

declare const wpApiSettings: any;

export interface PromiseData {
	//
}

export interface PromiseStoreData {
	source: string;
	destination: string;
	asset: string;
	quantity: number;
	ref: string;
	note: string;
}

@injectable()
export class PromiseRepository {
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
	
	store( promise: PromiseStoreData ) {
		promise.destination = 'user:' + promise.destination;
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'POST',
				headers: this.headers,
				body: JSON.stringify( {
					promise: promise,
				} ),
			}
			const url = this.namespace + 'promise';
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
			const url = this.namespace + 'promise';
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