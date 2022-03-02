import { injectable } from 'inversify';
import SettingsRepository from '../SettingsRepository';
import TokenWhitelistSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/TokenWhitelistSettingsRepositoryInterface';

@injectable()
export default class TokenWhitelistSettingsRepository extends SettingsRepository implements TokenWhitelistSettingsRepositoryInterface {
	protected settingsType: string = 'token-whitelist';
}
