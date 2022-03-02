import {
	TokenPromiseIndexParamsInterface,
	TokenPromiseShowParamsInterface,
	TokenPromiseStoreParamsInterface,
	TokenPromiseUpdateParamsInterface,
} from './../../../Interfaces/Services/ApiServiceInterface';

export default interface PromiseRepositoryInterface {
	index( params?: TokenPromiseIndexParamsInterface ): Promise<Array<any>>
	show( id: number, params?: TokenPromiseShowParamsInterface ): Promise<Array<any>>
	store( params: TokenPromiseStoreParamsInterface ): Promise<any>
	update( id: number, params: TokenPromiseUpdateParamsInterface ): Promise<any>
	destroy( id: number ): Promise<any>;
}
