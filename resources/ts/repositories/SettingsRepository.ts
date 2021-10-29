import { injectable, inject } from "inversify";
import { SettingsData } from '../interfaces';
import { AdminApiService } from '../services/AdminApiService';

@injectable()
export class SettingsRepository {
	adminApiService;
	
	constructor(
		@inject( AdminApiService ) adminApiService: AdminApiService
	) {
		this.adminApiService = adminApiService;
	}
	
	show() {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsShow().then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( params: SettingsData ) {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsUpdate( params ).then( result => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
