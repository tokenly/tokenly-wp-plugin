import {
	TokenMetaData,
} from '../../../Interfaces';

export default interface MetaRepositoryInterface {
	update( postId: number, params: TokenMetaData ): Promise<any>;
}
