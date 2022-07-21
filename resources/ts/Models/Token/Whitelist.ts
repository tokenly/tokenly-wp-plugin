import Model from '../Model';
import WhitelistInterface from '../../Interfaces/Models/Token/WhitelistInterface';

export default class Whitelist extends Model implements WhitelistInterface {
	public enabled?: boolean = null;
	public items?: object = null;
	
	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'enabled',
			'items',
		] );
	}
}