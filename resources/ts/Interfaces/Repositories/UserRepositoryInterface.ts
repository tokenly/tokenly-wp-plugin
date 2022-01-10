import {
	UserIndexParams,
	UserShowParams,
} from '../../Interfaces';

export default interface UserRepositoryInterface {
	index( params: UserIndexParams ): Promise<any>;
	show( id: number, params?: any ): Promise<any>;
	indexCreditBalance( id: number, params?: any ): Promise<any>;
	indexTokenBalance( id: number, params?: any ): Promise<any>;
}
