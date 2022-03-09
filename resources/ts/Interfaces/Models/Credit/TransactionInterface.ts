import ModelInterface from '../ModelInterface';

export default interface TransactionInterface extends ModelInterface {
	txUuid?: string;
	creditGroup?: string;
	account?: string;
	accountUuid?: string;
	amount?: string;
	oauthUserId?: string;
	ref?: string;
	createdAt?: string;
	updatedAt?: string;
}