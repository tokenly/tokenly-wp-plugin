import {
	TokenSourceIndexParamsInterface,
	TokenSourceShowParamsInterface,
	TokenSourceStoreParamsInterface,
	TokenSourceUpdateParamsInterface,
} from '../../../Interfaces/Services/ApiServiceInterface';
import SourceInterface from '../../Models/Token/SourceInterface';
import SourceCollectionInterface from '../../Collections/Token/SourceCollectionInterface';

export default interface SourceRepositoryInterface {
	index( params?: TokenSourceIndexParamsInterface ): Promise<SourceCollectionInterface>;
	show( id: string, params?: TokenSourceShowParamsInterface ): Promise<SourceInterface>
	store( params: TokenSourceStoreParamsInterface ): Promise<any>;
	update( address: string, params: TokenSourceUpdateParamsInterface ): Promise<any>;
	destroy( address: string ): Promise<any>;
}
