import { AuthData } from './../../Interfaces';

export default interface AuthServiceInterface {
	getStatus(): Promise<AuthData>;
	connect(): Promise<any>;
	disconnect(): Promise<any>;
}
