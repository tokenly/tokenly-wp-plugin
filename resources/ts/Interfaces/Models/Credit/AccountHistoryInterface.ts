import ModelInterface from '../ModelInterface';

export default interface AccountHistoryInterface extends ModelInterface {
	count?: number;
	account?: object;
	transactions?: object;
}