import Collection from '../Collection'
import BalanceCollectionInterface from '../../Interfaces/Collections/Token/BalanceCollectionInterface'
import Balance from '../../Models/Token/Balance'

export default class BalanceCollection extends Collection implements BalanceCollectionInterface {
	protected class = Balance
}
