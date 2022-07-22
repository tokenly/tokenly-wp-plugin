import ModelInterface from '../ModelInterface'

export default interface SourceInterface extends ModelInterface {
	addressId?: string
	assets?: object
	type?: string
	address?: object
}