import Model from '../Model';
import WhitelistItemInterface from '../../Interfaces/Models/Token/WhitelistItemInterface';

export default class WhitelistItem extends Model implements WhitelistItemInterface {
	protected _asset?: object = null;

	public get asset(): object|null {
		return this._asset ?? null;
	}

	public set asset( value: object ) {
		this._asset = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'asset',
		] );
	}
}