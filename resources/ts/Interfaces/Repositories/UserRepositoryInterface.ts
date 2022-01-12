import {
	UserIndexParams,
	UserShowParams,
} from '../../Interfaces';

export default interface UserRepositoryInterface {
	index( params: UserIndexParams ): Promise<any>;
	show( id: string, params?: any ): Promise<any>;
	creditBalanceIndex( id: string, params?: any ): Promise<any>;
	tokenAddressIndex( id: string, params?: any ): Promise<any>;
	tokenBalanceIndex( id: string, params?: any ): Promise<any>;
}
