import Collection from '../Collection';
import AccountCollectionInterface from '../../Interfaces/Collections/Credit/AccountCollectionInterface';
import Account from '../../Models/Credit/Account';

export default class AccountCollection extends Collection implements AccountCollectionInterface {
	protected class = Account;
}
