export default interface SettingsRepositoryInterface {
	show(): Promise<any>;
	update( params: any ): Promise<any>;
}
