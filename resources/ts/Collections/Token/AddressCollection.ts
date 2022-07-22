import Collection from '../Collection'
import AddressCollectionInterface from '../../Interfaces/Collections/Token/AddressCollectionInterface'
import Address from '../../Models/Token/Address'

export default class AddressCollection extends Collection implements AddressCollectionInterface {
	protected class = Address
}
