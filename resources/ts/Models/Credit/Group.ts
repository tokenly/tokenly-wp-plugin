import Model from '../Model';
import GroupInterface from '../../Interfaces/Models/Credit/GroupInterface';

export default class Group extends Model implements GroupInterface {
	protected _name?: string = null;
	protected _uuid?: string = null;
	protected _active?: boolean = null;
	protected _appWhitelist?: object = null;
	protected _createdAt?: string = null;
	protected _updatedAt?: string = null;

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

	public get active(): boolean|null {
		return this._active ?? null;
	}

	public set active( value: boolean ) {
		this._active = value;
	}

	public get appWhitelist(): object|null {
		return this._appWhitelist ?? null;
	}

	public set appWhitelist( value: object ) {
		this._appWhitelist = value;
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
		if ( data.app_whitelist ) {
			data.appWhitelist = data.app_whitelist;
			delete data.app_whitelist;
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
			'name',
			'uuid',
			'active',
			'appWhitelist',
			'createdAt',
			'updatedAt',
		] );
	}
}
