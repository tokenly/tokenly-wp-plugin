import Collection from '../Collection';
import TransactionCollectionInterface from '../../Interfaces/Collections/Credit/TransactionCollectionInterface';
import Transaction from '../../Models/Credit/Transaction';

export default class TransactionCollection extends Collection implements TransactionCollectionInterface {
	protected class = Transaction;
}
