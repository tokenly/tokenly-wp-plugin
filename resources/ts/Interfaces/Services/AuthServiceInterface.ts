import { AuthData } from './../../Interfaces';

export interface AuthServiceInterface {
	getStatus(): Promise<AuthData>;
	connect(): Promise<any>;
	disconnect(): Promise<any>;
}
