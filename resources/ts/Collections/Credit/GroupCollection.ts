import Collection from '../Collection'
import GroupCollectionInterface from '../../Interfaces/Collections/Credit/GroupCollectionInterface'
import Group from '../../Models/Credit/Group'

export default class GroupCollection extends Collection implements GroupCollectionInterface {
	protected class = Group
}
