import Model from '../Model';
import AssetInterface from '../../Interfaces/Models/Token/AssetInterface';

export default class Asset extends Model implements AssetInterface {
	public address?: string = null;
	public index?: string = null;

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'address',
			'index',
		] );
	}
}