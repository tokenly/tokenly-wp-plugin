import { injectable } from 'inversify';
import SettingsRepository from '../SettingsRepository';
import WhitelistSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/WhitelistSettingsRepositoryInterface';

@injectable()
export default class WhitelistSettingsRepository extends SettingsRepository implements WhitelistSettingsRepositoryInterface {
	settingsType: string = 'whitelist';
}
