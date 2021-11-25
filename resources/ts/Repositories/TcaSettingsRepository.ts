import { injectable, inject } from 'inversify';
import { SettingsData } from '../Interfaces';
import { TcaSettingsRepositoryInterface } from './../Interfaces/Repositories/TcaSettingsRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class TcaSettingsRepository implements TcaSettingsRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	show(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsTcaShow().then( ( result: SettingsData ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsTcaUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
