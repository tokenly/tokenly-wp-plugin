import Model from '../Model';
import WhitelistInterface from '../../Interfaces/Models/Token/WhitelistInterface';

export default class Whitelist extends Model implements WhitelistInterface {
	protected _enabled?: boolean = null;
	protected _items?: object = null;

	public get enabled(): boolean|null {
		return this._enabled ?? null;
	}

	public set enabled( value: boolean ) {
		this._enabled = value;
	}

	public get items(): object|null {
		return this._items ?? null;
	}

	public set items( value: object ) {
		this._items = value;
	}
	
	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'enabled',
			'items',
		] );
	}
}