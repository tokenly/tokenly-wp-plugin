import Model from '../Model'
import BalanceInterface from '../../Interfaces/Models/Token/BalanceInterface'
import AssetInterface from '../../Interfaces/Models/Token/AssetInterface'
import QuantityInterface from '../../Interfaces/Models/Token/QuantityInterface'
import MetaInterface from '../../Interfaces/Models/Token/MetaInterface'

export default class Balance extends Model implements BalanceInterface {
	public name?: string = null
	public precision?: number = null
	public asset?: AssetInterface = null
	public quantity?: QuantityInterface = null
	public meta?: MetaInterface = null

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