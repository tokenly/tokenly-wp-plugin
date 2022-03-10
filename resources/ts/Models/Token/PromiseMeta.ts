import Post from '../Post';
import PromiseMetaInterface from '../../Interfaces/Models/Token/PromiseMetaInterface';

export default class PromiseMeta extends Post implements PromiseMetaInterface {
	protected _promiseId?: number = null;
	protected _sourceUserId?: string = null;
	protected _sourceUser?: object = null;
	protected _destinationUserId?: string = null;
	protected _destinationUser?: object = null;

	public get promiseId(): number|null {
		return this._promiseId ?? null;
	}

	public set promiseId( value: number ) {
		this._promiseId = value;
	}

	public get sourceUserId(): string|null {
		return this._sourceUserId ?? null;
	}

	public set sourceUserId( value: string ) {
		this._sourceUserId = value;
	}

	public get sourceUser(): object|null {
		return this._sourceUser ?? null;
	}

	public set sourceUser( value: object ) {
		this._sourceUser = value;
	}

	public get destinationUserId(): string|null {
		return this._destinationUserId ?? null;
	}

	public set destinationUserId( value: string ) {
		this._destinationUserId = value;
	}

	public get destinationUser(): object|null {
		return this._destinationUser ?? null;
	}

	public set destinationUser( value: object ) {
		this._destinationUser = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.promise_id ) {
			data.promiseId = data.promise_id;
			delete data.promise_id;
		}
		if ( data.source_user_id ) {
			data.sourceUserId = data.source_user_id;
			delete data.source_user_id;
		}
		if ( data.source_user ) {
			data.sourceUser = data.source_user;
			delete data.source_user;
		}
		if ( data.destination_user_id ) {
			data.destinationUserId = data.destination_user_id;
			delete data.destination_user_id;
		}
		if ( data.destination_user ) {
			data.destinationUser = data.destination_user;
			delete data.destination_user;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'promiseId',
			'sourceUserId',
			'sourceUser',
			'destinationUserId',
			'destinationUser',
		] );
	}
}