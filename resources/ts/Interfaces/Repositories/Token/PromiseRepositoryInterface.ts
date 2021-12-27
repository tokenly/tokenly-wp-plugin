import {
	PromiseData,
	PromiseStoreParams,
	PromiseUpdateParams,
} from '../../../Interfaces';

export default interface PromiseRepositoryInterface {
	index( params: any ): Promise<Array<PromiseData>>
	show( id: number, params?: any ): Promise<Array<PromiseData>>
	store( params: PromiseStoreParams ): Promise<any>
	update( id: number, params: PromiseUpdateParams ): Promise<any>
	destroy( id: number ): Promise<any>;
}
