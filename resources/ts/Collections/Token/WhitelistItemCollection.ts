import Collection from '../Collection'
import WhitelistItemCollectionInterface from '../../Interfaces/Collections/Token/WhitelistItemCollectionInterface'
import WhitelistItem from '../../Models/Token/WhitelistItem'

export default class WhitelistItemCollection extends Collection implements WhitelistItemCollectionInterface {
	protected class = WhitelistItem
}
