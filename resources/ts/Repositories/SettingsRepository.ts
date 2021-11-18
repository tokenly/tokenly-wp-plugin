import { injectable, inject } from 'inversify';
import { SettingsData } from '../Interfaces';
import { SettingsRepositoryInterface } from './../Interfaces/Repositories/SettingsRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class SettingsRepository implements SettingsRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	show(): Promise<SettingsData> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsShow().then( ( result: SettingsData ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( params: SettingsData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
