import {
	TokenPromiseIndexParamsInterface,
	TokenPromiseShowParamsInterface,
	TokenPromiseStoreParamsInterface,
	TokenPromiseUpdateParamsInterface,
} from '../../../Interfaces/Services/ApiServiceInterface'
import PromiseCollectionInterface
	from '../../Collections/Token/PromiseCollectionInterface'
import PromiseInterface from '../../Models/Token/PromiseInterface'

export default interface PromiseRepositoryInterface {
	index(
		params?: TokenPromiseIndexParamsInterface
	): Promise<PromiseCollectionInterface>
	show(
		id: number, params?: TokenPromiseShowParamsInterface
	): Promise<PromiseInterface>
	store( params: TokenPromiseStoreParamsInterface ): Promise<any>
	update(
		id: number, params: TokenPromiseUpdateParamsInterface
	): Promise<any>
	destroy( id: number ): Promise<any>
}
