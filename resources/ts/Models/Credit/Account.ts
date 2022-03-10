import Model from '../Model';
import AccountInterface from '../../Interfaces/Models/Credit/AccountInterface';
import GroupInterface from '../../Interfaces/Models/Credit/GroupInterface';

export default class Account extends Model implements AccountInterface {
	protected _name?: string = null;
	protected _uuid?: string = null;
	protected _balance?: number = null;
	protected _oauthUser?: string = null;
	protected _createdAt?: string = null;
	protected _updatedAt?: string = null;
	protected _groupId?: string = null;
	protected _group?: GroupInterface;

	public get name(): string|null {
		return this._name ?? null;
	}

	public set name( value: string ) {
		this._name = value;
	}

	public get uuid(): string|null {
		return this._uuid ?? null;
	}

	public set uuid( value: string ) {
		this._uuid = value;
	}

	public get balance(): number|null {
		return this._balance ?? null;
	}

	public set balance( value: number ) {
		this._balance = value;
	}

	public get oauthUser(): string|null {
		return this._oauthUser ?? null;
	}

	public set oauthUser( value: string ) {
		this._oauthUser = value;
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

	public get groupId(): string|null {
		return this._groupId ?? null;
	}

	public set groupId( value: string ) {
		this._groupId = value;
	}

	public get group(): GroupInterface|null {
		return this._group ?? null;
	}

	public set group( value: GroupInterface ) {
		this._group = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.oauth_user ) {
			data.oauthUser = data.oauth_user;
			delete data.oauth_user;
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at;
			delete data.created_at;
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at;
			delete data.updated_at;
		}
		if ( data.group_id ) {
			data.groupId = data.group_id;
			delete data.group_id;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'name',
			'uuid',
			'balance',
			'oauthUser',
			'createdAt',
			'updatedAt',
			'groupId',
		] );
	}
}