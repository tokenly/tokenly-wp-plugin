import SettingsRepositoryInterface from '../Interfaces/Repositories/SettingsRepositoryInterface';

import { injectable, inject } from 'inversify';
import { TYPES } from '../Types';

import {
	ApiServiceInterface,
	SettingsUpdateParamsInterface,
} from '../Interfaces/Services/ApiServiceInterface';

@injectable()
export default class SettingsRepository implements SettingsRepositoryInterface {
	protected ApiService: ApiServiceInterface;
	protected settingsType: string;
	
	constructor(
		@inject( TYPES.Services.ApiServiceInterface ) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService;
	}

	protected formatResponse( response: any ): any {
		return response;
	}
	
	public update( params: SettingsUpdateParamsInterface ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.settingsUpdate( this.settingsType, params ).then( ( result: any ) => {
				result = this.formatResponse( result );
				resolve( result );
			} ).catch( error => {
				reject( error );
			} );
		} );
	}
}
