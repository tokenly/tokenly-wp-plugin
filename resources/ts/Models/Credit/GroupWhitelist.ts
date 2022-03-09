import Settings from '../Settings';
import GroupWhitelistInterface from '../../Interfaces/Models/Credit/GroupWhitelistInterface';

export default class GroupWhitelist extends Settings implements GroupWhitelistInterface {
	protected _items?: object = null;

	public get items(): object|null {
		return this._items ?? null;
	}

	public set items( value: object ) {
		this._items = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'items',
		] );
	}
}