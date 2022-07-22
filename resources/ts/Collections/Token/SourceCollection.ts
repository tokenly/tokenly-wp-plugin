import Collection from '../Collection'
import SourceCollectionInterface from '../../Interfaces/Collections/Token/SourceCollectionInterface'
import Source from '../../Models/Token/Source'

export default class SourceCollection extends Collection implements SourceCollectionInterface {
	protected class = Source
}
