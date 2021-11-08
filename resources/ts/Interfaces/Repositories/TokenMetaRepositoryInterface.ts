import {
	TokenMetaData,
} from './../../Interfaces';

export interface TokenMetaRepositoryInterface {
	update( postId: number, params: TokenMetaData ): Promise<any>;
}
