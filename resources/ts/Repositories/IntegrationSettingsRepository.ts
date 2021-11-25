import { injectable, inject } from 'inversify';
import { SettingsData } from '../Interfaces';
import { IntegrationSettingsRepositoryInterface } from './../Interfaces/Repositories/IntegrationSettingsRepositoryInterface';
import { AdminApiServiceInterface } from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export class IntegrationSettingsRepository implements IntegrationSettingsRepositoryInterface {
	adminApiService;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	show(): Promise<SettingsData> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsIntegrationShow().then( ( result: SettingsData ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( params: SettingsData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsIntegrationUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
