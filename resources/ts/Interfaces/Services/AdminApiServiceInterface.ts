import {
	SourceData,
	PromiseData,
	PromiseStoreParams,
	PromiseUpdateParams,
	TokenMetaData,
	UserIndexParams,
	UserShowParams,
} from './../../Interfaces';

export interface AdminApiServiceInterface {
	settingsShow( type: string ): Promise<any>;
	settingsUpdate( type: string, params: any ): Promise<any>;
	sourceIndex( params: any ): Promise<Array<SourceData>>;
	sourceStore( params: SourceData ): Promise<any>;
	sourceUpdate( address: string, params: SourceData ): Promise<any>;
	sourceDestroy( address: string ): Promise<any>;
	creditGroupIndex(): Promise<Array<any>>;
	creditGroupStore( params: any ): Promise<any>;
	creditGroupUpdate( params: any ): Promise<any>;
	creditTransactionIndex(): Promise<Array<any>>;
	creditTransactionStore( params: any ): Promise<any>;
	promiseIndex( params: any ): Promise<Array<PromiseData>>;
	promiseStore( params: PromiseStoreParams ): Promise<any>;
	promiseUpdate( promiseId: number, params: PromiseUpdateParams ): Promise<any>;
	promiseDestroy( promiseId: number ): Promise<any>;
	tokenMetaShow( postId: number ): Promise<TokenMetaData>;
	tokenMetaUpdate( postId: number, params: TokenMetaData ): Promise<any>;
	userIndex( params: UserIndexParams ): Promise<any>;
	userShow( userId: number, params: UserShowParams ): Promise<any>;
	makeRequest( method: string, route: string, args: object ): Promise<any>;
}
