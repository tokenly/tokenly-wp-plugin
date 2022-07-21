import Settings from '../Settings';
import GroupWhitelistInterface from '../../Interfaces/Models/Credit/GroupWhitelistInterface';

export default class GroupWhitelist extends Settings implements GroupWhitelistInterface {
	public items?: object = null;

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'items',
		] );
	}
}