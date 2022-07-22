import Model from '../Model'
import BalanceInterface from '../../Interfaces/Models/Token/BalanceInterface'

export default class Balance extends Model implements BalanceInterface {
	public name?: string = null
	public precision?: number = null
	public asset?: object = null
	public quantity?: number = null
	public meta?: object = null

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'name',
			'precision',
			'asset',
			'quantity',
			'meta',
		] )
	}
}