import {
	UserIndexParams,
	UserShowParams,
} from '../../Interfaces';

export default interface UserRepositoryInterface {
	index( params: UserIndexParams ): Promise<any>;
	show( userId: number, params: UserShowParams ): Promise<any>;
}
