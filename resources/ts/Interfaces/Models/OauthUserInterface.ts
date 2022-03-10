import ModelInterface from './ModelInterface';

export default interface OauthUserInterface extends ModelInterface {
	id?: string;
	username?: string;
	address?: object;
	creditAccount?: object;
	balance?: object;
}