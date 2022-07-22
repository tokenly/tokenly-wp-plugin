import Model from '../Model'
import GroupHistoryInterface from '../../Interfaces/Models/Credit/GroupHistoryInterface'

export default class GroupHistory extends Model implements GroupHistoryInterface {
	public balance?: object = null
	public count?: number = null
	public transactions?: object = null

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'balance',
			'count',
			'transactions',
		] )
	}
}