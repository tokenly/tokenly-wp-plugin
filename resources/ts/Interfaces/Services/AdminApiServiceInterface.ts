import {
	SettingsData,
	SourceData,
	PromiseData,
	PromiseStoreParams,
	PromiseUpdateParams,
	TokenMetaData,
	UserIndexParams,
	UserShowParams,
	WhitelistData
} from './../../Interfaces';

export interface AdminApiServiceInterface {
	settingsIntegrationShow(): Promise<SettingsData>;
	settingsIntegrationUpdate( params: SettingsData ): Promise<any>;
	settingsTcaShow(): Promise<any>;
	settingsTcaUpdate( params: any ): Promise<any>;
	sourceIndex(): Promise<Array<SourceData>>;
	sourceStore( params: SourceData ): Promise<any>;
	sourceUpdate( address: string, params: SourceData ): Promise<any>;
	sourceDestroy( address: string ): Promise<any>;
	creditGroupIndex(): Promise<Array<any>>;
	creditGroupStore( params: any ): Promise<any>;
	creditGroupUpdate( params: any ): Promise<any>;
	promiseIndex(): Promise<Array<PromiseData>>;
	promiseStore( params: PromiseStoreParams ): Promise<any>;
	promiseUpdate( promiseId: number, params: PromiseUpdateParams ): Promise<any>;
	promiseDestroy( promiseId: number ): Promise<any>;
	tokenMetaShow( postId: number ): Promise<TokenMetaData>;
	tokenMetaUpdate( postId: number, params: TokenMetaData ): Promise<any>;
	userIndex( params: UserIndexParams ): Promise<any>;
	userShow( userId: number, params: UserShowParams ): Promise<any>;
	whitelistShow(): Promise<any>;
	whitelistUpdate( params: WhitelistData ): Promise<any>;
	makeRequest( method: string, route: string, args: object ): Promise<any>;
}
