import Model from './Model';
import UserInterface from '../Interfaces/Models/UserInterface';

import OauthUserInterface from '../Interfaces/Models/OauthUserInterface';

export default class User extends Model implements UserInterface {
	protected _id?: number;
	protected _name?: string;
	protected _nameDisplay?: string;
	protected _description?: string;
	protected _avatar?: string;
	protected _canConnect?: boolean;
	protected _oauthUser?: OauthUserInterface;

	public get id(): number|null {
		return this._id ?? null;
	}

	public set id( value: number ) {
		this._id = value;
	}

	public get name(): string|null {
		return this._name ?? null;
	}

	public set name( value: string ) {
		this._name = value;
	}

	public get nameDisplay(): string|null {
		return this._nameDisplay ?? null;
	}

	public set nameDisplay( value: string ) {
		this._nameDisplay = value;
	}

	public get description(): string|null {
		return this._description ?? null;
	}

	public set description( value: string ) {
		this._description = value;
	}

	public get avatar(): string|null {
		return this._avatar ?? null;
	}

	public set avatar( value: string ) {
		this._avatar = value;
	}

	public get canConnect(): boolean|null {
		return this._canConnect ?? null;
	}

	public set canConnect( value: boolean ) {
		this._canConnect = value;
	}

	public get oauthUser(): OauthUserInterface|null {
		return this._oauthUser ?? null;
	}

	public set oauthUser( value: OauthUserInterface ) {
		this._oauthUser = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.name_display ) {
			data.nameDisplay = data.name_display;
			delete data.name_display;
		}
		if ( data.can_connect ) {
			data.canConnect = data.can_connect;
			delete data.can_connect;
		}
		if ( data.oauth_user ) {
			data.oauthUser = data.oauth_user;
			delete data.oauth_user;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'name',
			'nameDisplay',
			'avatar',
			'canConnect',
			'oauthUser',
		] );
	}
}