import Model from '../Model'
import AccountHistoryInterface from '../../Interfaces/Models/Credit/AccountHistoryInterface'

export default class AccountHistory extends Model implements AccountHistoryInterface {
	public count?: number = null
	public account?: object = null
	public transactions?: object = null

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'count',
			'account',
			'transactions',
		] )
	}
}