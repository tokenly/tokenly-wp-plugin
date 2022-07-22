import { injectable } from 'inversify'
import SettingsRepository from '../SettingsRepository'
import OauthSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface'

@injectable()
export default class OauthSettingsRepository
	extends SettingsRepository
	implements OauthSettingsRepositoryInterface
{
	protected settingsType: string = 'oauth'
}
