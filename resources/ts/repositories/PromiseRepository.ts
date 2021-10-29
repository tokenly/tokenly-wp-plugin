import { injectable, inject } from "inversify";
import { AdminApiService } from '../services/AdminApiService';

export interface PromiseStoreData {
	source: string;
	destination: number;
	asset: string;
	quantity: number;
	ref: string;
	note: string;
}

export interface PromiseData {
	//
}

@injectable()
export class PromiseRepository {
	AdminApiService;
	
	constructor(
		@inject( AdminApiService ) AdminApiService: AdminApiService
	) {
		this.AdminApiService = AdminApiService;
	}
	
	store( promise: PromiseStoreData ) {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'POST',
				headers: this.AdminApiService.headers,
				body: JSON.stringify( {
					promise: promise,
				} ),
			}
			const url = this.AdminApiService.namespace + 'promise';
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
				headers: this.AdminApiService.headers,
			}
			const url = this.AdminApiService.namespace + 'promise';
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
