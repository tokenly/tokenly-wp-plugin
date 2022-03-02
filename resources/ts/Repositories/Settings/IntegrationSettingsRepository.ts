import { injectable } from 'inversify';
import SettingsRepository from '../SettingsRepository';
import IntegrationSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';

@injectable()
export default class IntegrationSettingsRepository extends SettingsRepository implements IntegrationSettingsRepositoryInterface {
	protected settingsType: string = 'integration';
}
