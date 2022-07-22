import PostCollection from '../PostCollection'
import PromiseMetaCollectionInterface from '../../Interfaces/Collections/Token/PromiseMetaCollectionInterface'
import PromiseMeta from '../../Models/Token/PromiseMeta'

export default class PromiseMetaCollection extends PostCollection implements PromiseMetaCollectionInterface {
	protected class = PromiseMeta
}
