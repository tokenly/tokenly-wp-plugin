import ModelInterface from '../ModelInterface';

export default interface AccountInterface extends ModelInterface {
	name?: string;
	uuid?: string;
	balance?: number;
	oauthUser?: string;
	createdAt?: string;
	updatedAt?: string;
	groupId?: string;
}