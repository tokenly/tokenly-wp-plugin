import Model from '../Model'
import WhitelistItemInterface
	from '../../Interfaces/Models/Token/WhitelistItemInterface'

export default class WhitelistItem extends Model
	implements WhitelistItemInterface
{
	public asset?: object = null

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'asset',
		] )
	}
}