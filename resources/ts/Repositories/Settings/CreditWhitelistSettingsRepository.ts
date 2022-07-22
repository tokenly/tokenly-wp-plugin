import { injectable } from 'inversify'
import SettingsRepository from '../SettingsRepository'
import CreditWhitelistSettingsRepositoryInterface
	from '../../Interfaces/Repositories/Settings/CreditWhitelistSettingsRepositoryInterface'

@injectable()
export default class CreditWhitelistSettingsRepository
	extends SettingsRepository
	implements CreditWhitelistSettingsRepositoryInterface
{
	protected settingsType: string = 'credit-whitelist'
}
