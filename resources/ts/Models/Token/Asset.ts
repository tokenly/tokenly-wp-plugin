import Model from '../Model';
import AssetInterface from '../../Interfaces/Models/Token/AssetInterface';

export default class Asset extends Model implements AssetInterface {
	protected _address?: string = null;
	protected _index?: string = null;

	public get address(): string|null {
		return this._address ?? null;
	}

	public set address( value: string ) {
		this._address = value;
	}

	public get index(): string|null {
		return this._index ?? null;
	}

	public set index( value: string ) {
		this._index = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'address',
			'index',
		] );
	}
}