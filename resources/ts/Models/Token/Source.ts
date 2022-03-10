import Model from '../Model';
import SourceInterface from '../../Interfaces/Models/Token/SourceInterface';

export default class Source extends Model implements SourceInterface {
	protected _addressId?: string = null;
	protected _assets?: object = null;
	protected _type?: string = null;
	protected _address?: object = null;

	public get addressId(): string|null {
		return this._addressId ?? null;
	}

	public set addressId( value: string ) {
		this._addressId = value;
	}

	public get assets(): object|null {
		return this._assets ?? null;
	}

	public set assets( value: object ) {
		this._assets = value;
	}

	public get type(): string|null {
		return this._type ?? null;
	}

	public set type( value: string ) {
		this._type = value;
	}

	public get address(): object|null {
		return this._address ?? null;
	}

	public set address( value: object ) {
		this._address = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.address_id ) {
			data.addressId = data.address_id;
			delete data.address_id;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'addressId',
			'assets',
			'type',
			'address',
		] );
	}
}