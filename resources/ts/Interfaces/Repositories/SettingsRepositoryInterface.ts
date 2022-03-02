import { SettingsUpdateParamsInterface } from './../../Interfaces/Services/ApiServiceInterface';

export default interface SettingsRepositoryInterface {
	update( params: SettingsUpdateParamsInterface ): Promise<any>;
}
