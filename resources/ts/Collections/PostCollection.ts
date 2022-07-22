import Collection from './Collection'
import PostCollectionInterface from '../Interfaces/Collections/PostCollectionInterface'
import ProtectableInterface from '../Interfaces/Mixins/ProtectableInterface'
import Post from '../Models/Post'

export default class PostCollection extends Collection implements PostCollectionInterface, ProtectableInterface {
	protected class = Post
}
