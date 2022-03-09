import { injectable } from 'inversify';
import SettingsRepository from '../SettingsRepository';
import IntegrationSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';

import IntegrationSettings from '../../Models/Settings/IntegrationSettings';

@injectable()
export default class IntegrationSettingsRepository extends SettingsRepository implements IntegrationSettingsRepositoryInterface {
	protected settingsType: string = 'integration';

	protected formatResponse( response: any ): any {
		return ( new IntegrationSettings() ).fromJson( response );
	}
}
