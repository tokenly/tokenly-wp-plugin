import {
	UserIndexParams,
	UserShowParams,
} from '../../Interfaces';

export default interface UserRepositoryInterface {
	index( params: UserIndexParams ): Promise<any>;
	show( userId: string, params: any ): Promise<any>;
}
