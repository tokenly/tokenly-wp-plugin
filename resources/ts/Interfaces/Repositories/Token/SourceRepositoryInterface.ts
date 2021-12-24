import {
	SourceData,
} from '../../../Interfaces';

export default interface SourceRepositoryInterface {
	index( params: any ): Promise<Array<SourceData>>;
	store( params: SourceData ): Promise<any>;
	update( address: string, params: SourceData ): Promise<any>;
	destroy( address: string ): Promise<any>;
}
