import { injectable } from 'inversify';
import { SettingsRepository } from './../SettingsRepository';
import { OauthSettingsRepositoryInterface } from './../../Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';

@injectable()
export class OauthSettingsRepository extends SettingsRepository implements OauthSettingsRepositoryInterface {
	settingsType: string = 'oauth';
}
