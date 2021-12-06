import { injectable } from 'inversify';
import { SettingsRepository } from './../SettingsRepository';
import { TcaSettingsRepositoryInterface } from './../../Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';

@injectable()
export class TcaSettingsRepository extends SettingsRepository implements TcaSettingsRepositoryInterface {
	settingsType: string = 'tca';
}
