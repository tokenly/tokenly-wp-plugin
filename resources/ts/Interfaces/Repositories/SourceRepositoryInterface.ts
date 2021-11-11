import {
	SourceData,
} from './../../Interfaces';

export interface SourceRepositoryInterface {
	index(): Promise<Array<SourceData>>;
	store( params: SourceData ): Promise<any>;
	update( address: string, params: SourceData ): Promise<any>;
	destroy( address: string ): Promise<any>;
}