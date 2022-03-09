import ModelInterface from '../ModelInterface';

export default interface AddressInterface extends ModelInterface {
	address?: string;
	type?: string;
	label?: string;
	public?: boolean;
	active?: boolean;
	verified?: boolean;
	verifyCode?: string;
	balance?: object;
}