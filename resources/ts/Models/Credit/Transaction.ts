import Model from '../Model';
import TransactionInterface from '../../Interfaces/Models/Credit/TransactionInterface';

export default class Transaction extends Model implements TransactionInterface {
	protected _txUuid?: string = null;
	protected _creditGroup?: string = null;
	protected _account?: string = null;
	protected _accountUuid?: string = null;
	protected _amount?: string = null;
	protected _oauthUserId?: string = null;
	protected _ref?: string = null;
	protected _createdAt?: string = null;
	protected _updatedAt?: string = null;

	public get txUuid(): string|null {
		return this._txUuid ?? null;
	}

	public set txUuid( value: string ) {
		this._txUuid = value;
	}

	public get creditGroup(): string|null {
		return this._creditGroup ?? null;
	}

	public set creditGroup( value: string ) {
		this._creditGroup = value;
	}

	public get account(): string|null {
		return this._account ?? null;
	}

	public set account( value: string ) {
		this._account = value;
	}

	public get accountUuid(): string|null {
		return this._accountUuid ?? null;
	}

	public set accountUuid( value: string ) {
		this._accountUuid = value;
	}

	public get amount(): string|null {
		return this._amount ?? null;
	}

	public set amount( value: string ) {
		this._amount = value;
	}

	public get oauthUserId(): string|null {
		return this._oauthUserId ?? null;
	}

	public set oauthUserId( value: string ) {
		this._oauthUserId = value;
	}

	public get ref(): string|null {
		return this._ref ?? null;
	}

	public set ref( value: string ) {
		this._ref = value;
	}

	public get createdAt(): string|null {
		return this._createdAt ?? null;
	}

	public set createdAt( value: string ) {
		this._createdAt = value;
	}

	public get updatedAt(): string|null {
		return this._updatedAt ?? null;
	}

	public set updatedAt( value: string ) {
		this._updatedAt = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.tx_uuid ) {
			data.txUuid = data.tx_uuid;
			delete data.tx_uuid;
		}
		if ( data.credit_group ) {
			data.creditGroup = data.credit_group;
			delete data.credit_group;
		}
		if ( data.account_uuid ) {
			data.accountUuid = data.account_uuid;
			delete data.account_uuid;
		}
		if ( data.oauth_user_id ) {
			data.oauthUserId = data.oauth_user_id;
			delete data.oauth_user_id;
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at;
			delete data.created_at;
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at;
			delete data.updated_at;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'txUuid',
			'creditGroup',
			'account',
			'accountUuid',
			'amount',
			'oauthUserId',
			'ref',
			'createdAt',
			'updatedAt',
		] );
	}
}