import { injectable, inject } from 'inversify';
import SettingsRepositoryInterface from './../Interfaces/Repositories/SettingsRepositoryInterface';
import AdminApiServiceInterface from '../Interfaces/Services/AdminApiServiceInterface';
import { TYPES } from './../Types';

@injectable()
export default class SettingsRepository implements SettingsRepositoryInterface {
	adminApiService;
	settingsType: string;
	
	constructor(
		@inject( TYPES.AdminApiServiceInterface ) adminApiService: AdminApiServiceInterface
	) {
		this.adminApiService = adminApiService;
	}
	
	show(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsShow( this.settingsType ).then( ( result: any ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
	
	update( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.adminApiService.settingsUpdate( this.settingsType, params ).then( ( result: any ) => {
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		});
	}
}
