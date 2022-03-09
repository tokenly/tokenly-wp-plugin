import {
	TokenSourceIndexParamsInterface,
	TokenSourceShowParamsInterface,
	TokenSourceStoreParamsInterface,
	TokenSourceUpdateParamsInterface,
} from '../../../Interfaces/Services/ApiServiceInterface';
import SourceInterface from '../../Models/Token/SourceInterface';

export default interface SourceRepositoryInterface {
	index( params?: TokenSourceIndexParamsInterface ): Promise<Array<SourceInterface>>;
	show( id: string, params?: TokenSourceShowParamsInterface ): Promise<SourceInterface>
	store( params: TokenSourceStoreParamsInterface ): Promise<any>;
	update( address: string, params: TokenSourceUpdateParamsInterface ): Promise<any>;
	destroy( address: string ): Promise<any>;
}
