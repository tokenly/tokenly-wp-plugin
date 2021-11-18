import {
	UserIndexParams,
	UserShowParams,
} from './../../Interfaces';

export interface UserRepositoryInterface {
	index( params: UserIndexParams ): Promise<any>;
	show( userId: number, params: UserShowParams ): Promise<any>;
}
