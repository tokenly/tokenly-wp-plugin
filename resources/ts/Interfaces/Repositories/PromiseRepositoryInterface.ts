import {
	PromiseData,
	PromiseStoreParams,
	PromiseUpdateParams,
} from './../../Interfaces';

export interface PromiseRepositoryInterface {
	index( params: any ): Promise<Array<PromiseData>>
	store( params: PromiseStoreParams ): Promise<any>
	update( promiseId: number, params: PromiseUpdateParams ): Promise<any>
	destroy( promiseId: number ): Promise<any>;
}
