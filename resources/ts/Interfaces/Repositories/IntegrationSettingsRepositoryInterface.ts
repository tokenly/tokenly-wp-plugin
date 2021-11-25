import {
	SettingsData,
} from './../../Interfaces';

export interface IntegrationSettingsRepositoryInterface {
	show(): Promise<SettingsData>;
	update( params: SettingsData ): Promise<any>;
}
