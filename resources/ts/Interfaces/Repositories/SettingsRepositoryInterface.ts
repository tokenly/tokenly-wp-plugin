export interface SettingsRepositoryInterface {
	show(): Promise<any>;
	update( params: any ): Promise<any>;
}
