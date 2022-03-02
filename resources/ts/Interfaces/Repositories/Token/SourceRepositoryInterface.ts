import {
	TokenSourceIndexParamsInterface,
	TokenSourceShowParamsInterface,
	TokenSourceStoreParamsInterface,
	TokenSourceUpdateParamsInterface,
} from './../../../Interfaces/Services/ApiServiceInterface';

export default interface SourceRepositoryInterface {
	index( params?: TokenSourceIndexParamsInterface ): Promise<Array<any>>;
	show( id: string, params?: TokenSourceShowParamsInterface ): Promise<Array<any>>
	store( params: TokenSourceStoreParamsInterface ): Promise<any>;
	update( address: string, params: TokenSourceUpdateParamsInterface ): Promise<any>;
	destroy( address: string ): Promise<any>;
}
