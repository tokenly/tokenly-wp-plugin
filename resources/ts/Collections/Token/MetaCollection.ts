import PostCollection from '../PostCollection'
import MetaCollectionInterface from '../../Interfaces/Collections/Token/MetaCollectionInterface'
import Meta from '../../Models/Token/Meta'

export default class MetaCollection extends PostCollection implements MetaCollectionInterface {
	protected class = Meta
}
