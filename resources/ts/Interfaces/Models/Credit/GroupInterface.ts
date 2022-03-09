import ModelInterface from '../ModelInterface';

export default interface GroupInterface extends ModelInterface {
	name?: string;
	uuid?: string;
	active?: boolean;
	appWhitelist?: object;
	createdAt?: string;
	updatedAt?: string;
}