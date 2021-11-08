import {
	SettingsData,
} from './../../Interfaces';

export interface SettingsRepositoryInterface {
	show(): Promise<SettingsData>;
	update( params: SettingsData ): Promise<any>;
}
