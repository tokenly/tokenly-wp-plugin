import {
	SourceData,
	PromiseData,
	PromiseStoreParams,
	PromiseUpdateParams,
	TokenMetaData,
	UserIndexParams,
	UserShowParams,
} from './../../Interfaces';

export default interface AdminApiServiceInterface {
	creditGroupIndex( params: any ): Promise<Array<any>>;
	creditGroupShow( uuid: string, params?: any ): Promise<Array<any>>;
	creditGroupStore( params: any ): Promise<any>;
	creditGroupUpdate( uuid: string, params: any ): Promise<any>;
	creditTransactionIndex( params: any ): Promise<Array<any>>;
	creditTransactionStore( params: any ): Promise<any>;
	settingsShow( type: string ): Promise<any>;
	settingsUpdate( type: string, params: any ): Promise<any>;
	tokenAddressIndex( params: any ): Promise<Array<any>>;
	tokenBalanceIndex( params: any ): Promise<Array<any>>;
	tokenSourceIndex( params: any ): Promise<Array<SourceData>>;
	tokenSourceShow( id: string, params?: any ): Promise<Array<any>>;
	tokenSourceStore( params: SourceData ): Promise<any>;
	tokenSourceUpdate( address: string, params: SourceData ): Promise<any>;
	tokenSourceDestroy( address: string ): Promise<any>;
	tokenPromiseIndex( params: any ): Promise<Array<PromiseData>>;
	tokenPromiseShow( id: number, params?: any ): Promise<Array<any>>;
	tokenPromiseStore( params: PromiseStoreParams ): Promise<any>;
	tokenPromiseUpdate( promiseId: number, params: PromiseUpdateParams ): Promise<any>;
	tokenPromiseDestroy( promiseId: number ): Promise<any>;
	tokenMetaShow( postId: number ): Promise<TokenMetaData>;
	tokenMetaUpdate( postId: number, params: TokenMetaData ): Promise<any>;
	userIndex( params: UserIndexParams ): Promise<any>;
	userShow( userId: number, params: UserShowParams ): Promise<any>;
	makeRequest( method: string, route: string, args: object ): Promise<any>;
}
