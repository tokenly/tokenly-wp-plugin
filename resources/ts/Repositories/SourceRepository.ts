import { injectable, inject } from 'inversify';
import { SourceData } from '../Interfaces';
import { SourceRepositoryInterface } from './../Interfaces/Repositories/SourceRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class SourceRepository implements SourceRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}

	index(): Promise<Array<SourceData>> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.sourceIndex().then( ( result: Array<SourceData> ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	store( params: SourceData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.sourceStore( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	update( address: string, params: SourceData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.sourceUpdate( address, params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}

	destroy( address: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.sourceDestroy( address ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
