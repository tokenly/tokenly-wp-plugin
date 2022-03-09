import Model from '../Model';
import AddressInterface from '../../Interfaces/Models/Token/AddressInterface';

export default class Address extends Model implements AddressInterface {
	protected _address?: string = null;
	protected _type?: string = null;
	protected _label?: string = null;
	protected _public?: boolean = null;
	protected _active?: boolean = null;
	protected _verified?: boolean = null;
	protected _verifyCode?: string = null;
	protected _balance?: object = null;

	public get address(): string|null {
		return this._address ?? null;
	}

	public set address( value: string ) {
		this._address = value;
	}

	public get type(): string|null {
		return this._type ?? null;
	}

	public set type( value: string ) {
		this._type = value;
	}

	public get label(): string|null {
		return this._label ?? null;
	}

	public set label( value: string ) {
		this._label = value;
	}

	public get public(): boolean|null {
		return this._public ?? null;
	}

	public set public( value: boolean ) {
		this._public = value;
	}

	public get active(): boolean|null {
		return this._active ?? null;
	}

	public set active( value: boolean ) {
		this._active = value;
	}

	public get verified(): boolean|null {
		return this._verified ?? null;
	}

	public set verified( value: boolean ) {
		this._verified = value;
	}

	public get verifyCode(): string|null {
		return this._verifyCode ?? null;
	}

	public set verifyCode( value: string ) {
		this._verifyCode = value;
	}

	public get balance(): object|null {
		return this._balance ?? null;
	}

	public set balance( value: object ) {
		this._balance = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.verify_code ) {
			data.verifyCode = data.verify_code;
			delete data.verify_code;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'address',
			'type',
			'label',
			'public',
			'active',
			'verified',
			'verifyCode',
		] );
	}
}