import ModelInterface from '../ModelInterface'
import AddressInterface from './AddressInterface';

export default interface SourceInterface extends ModelInterface {
	addressId?: string
	assets?: Array<string>
	type?: string
	address?: AddressInterface
}