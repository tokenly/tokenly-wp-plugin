import ModelInterface from '../ModelInterface';

export default interface QuantityInterface extends ModelInterface {
	value?: number;
	valueSat?: number;
	precision?: number;
}