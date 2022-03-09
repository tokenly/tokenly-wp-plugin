import Model from './Model';
import OauthUserInterface from '../Interfaces/Models/OauthUserInterface';

export default class OauthUser extends Model implements OauthUserInterface {
	protected _id?: string = null;
	protected _username?: string = null;
	protected _address?: object;
	protected _creditAccount?: object;
	protected _balance?: object;
	
	public get id() {
		return this._id ?? null;
	}

	public set id( value: string ) {
		this._id = value;
	}

	public get username(): string|null {
		return this._username ?? null;
	}

	public set username( value: string ) {
		this._username = value;
	}

	public get address(): object|null {
		return this._address ?? null;
	}

	public set address( value: object ) {
		this._address = value;
	}

	public get creditAccount(): object|null {
		return this._creditAccount ?? null;
	}

	public set creditAccount( value: object ) {
		this._creditAccount = value;
	}

	public get balance(): object|null {
		return this._balance ?? null;
	}

	public set balance( value: object ) {
		this._balance = value;
	}
	
	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'username',
			'address',
			'creditAccount',
			'balance',
		] );
	}

	public fromJson( data: any = {} ): this {
		if ( data.credit_account ) {
			data.creditAccount = data.credit_account;
			delete data.credit_account;
		}
		return super.fromJson( data );
	}
}