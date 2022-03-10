import ModelInterface from './ModelInterface';

export default interface TermInterface extends ModelInterface {
	id?: number;
	name?: string;
	description?: string;
	slug?: string;
	link?: string;
}