import Model from '../Model';
import WhitelistInterface from '../../Interfaces/Models/Token/WhitelistInterface';

export default class Whitelist extends Model implements WhitelistInterface {
	protected enabled?: boolean = null;
	protected items?: object = null;

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'enabled',
			'items',
		] );
	}
}