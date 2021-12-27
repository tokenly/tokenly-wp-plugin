import { injectable, inject } from 'inversify';
import { SourceData } from '../../Interfaces';
import SourceRepositoryInterface from '../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import AdminApiServiceInterface from '../../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from '../../Types';

@injectable()
export default class SourceRepository implements SourceRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.Services.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index( params: any ): Promise<Array<SourceData>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenSourceIndex( params ).then( ( result: Array<SourceData> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	store( params: SourceData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenSourceStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	update( address: string, params: SourceData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenSourceUpdate( address, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	destroy( address: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.tokenSourceDestroy( address ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
