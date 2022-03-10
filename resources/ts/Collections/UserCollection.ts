import Collection from './Collection';
import UserCollectionInterface from '../Interfaces/Collections/UserCollectionInterface';
import User from '../Models/User';

export default class UserCollection extends Collection implements UserCollectionInterface {
	protected class = User;
}
