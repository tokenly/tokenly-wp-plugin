import ModelInterface from '../ModelInterface';
import GroupInterface from './GroupInterface';

export default interface AccountInterface extends ModelInterface {
	name?: string;
	uuid?: string;
	balance?: number;
	oauthUser?: string;
	createdAt?: string;
	updatedAt?: string;
	groupId?: string;
	group?: GroupInterface;
}