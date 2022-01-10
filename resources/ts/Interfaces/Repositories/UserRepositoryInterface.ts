import {
	UserIndexParams,
	UserShowParams,
} from '../../Interfaces';

export default interface UserRepositoryInterface {
	index( params: UserIndexParams ): Promise<any>;
	show( id: string, params?: any ): Promise<any>;
	indexCreditBalance( id: string, params?: any ): Promise<any>;
	indexTokenBalance( id: string, params?: any ): Promise<any>;
}
