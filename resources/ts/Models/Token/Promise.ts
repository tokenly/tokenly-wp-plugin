import Model from '../Model';
import PromiseInterface from '../../Interfaces/Models/Token/PromiseInterface';

export default class Promise extends Model implements PromiseInterface {
	protected _sourceId?: string = null;
	protected _destination?: string = null;
	protected _fingerprint?: string = null;
	protected _txid?: string = null;
	protected _createdAt?: string = null;
	protected _updatedAt?: string = null;
	protected _expiration?: string = null;
	protected _ref?: string = null;
	protected _pseudo?: boolean = null;
	protected _note?: string = null;
	protected _protocol?: string = null;
	protected _chain?: string = null;
	protected _promiseId?: number = null;
	protected _asset?: object = null;
	protected _source?: object = null;
	protected _quantity?: object = null;
	protected _promiseMeta?: object = null;
	protected _tokenMeta?: object = null;

	public get sourceId(): string|null {
		return this._sourceId ?? null;
	}

	public set sourceId( value: string ) {
		this._sourceId = value;
	}

	public get destination(): string|null {
		return this._destination ?? null;
	}

	public set destination( value: string ) {
		this._destination = value;
	}

	public get fingerprint(): string|null {
		return this._fingerprint ?? null;
	}

	public set fingerprint( value: string ) {
		this._fingerprint = value;
	}

	public get txid(): string|null {
		return this._txid ?? null;
	}

	public set txid( value: string ) {
		this._txid = value;
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

	public get expiration(): string|null {
		return this._expiration ?? null;
	}

	public set expiration( value: string ) {
		this._expiration = value;
	}

	public get ref(): string|null {
		return this._ref ?? null;
	}

	public set ref( value: string ) {
		this._ref = value;
	}

	public get pseudo(): boolean|null {
		return this._pseudo ?? null;
	}

	public set pseudo( value: boolean ) {
		this._pseudo = value;
	}

	public get note(): string|null {
		return this._note ?? null;
	}

	public set note( value: string ) {
		this._note = value;
	}

	public get protocol(): string|null {
		return this._protocol ?? null;
	}

	public set protocol( value: string ) {
		this._protocol = value;
	}

	public get chain(): string|null {
		return this._chain ?? null;
	}

	public set chain( value: string ) {
		this._chain = value;
	}

	public get promiseId(): number|null {
		return this._promiseId ?? null;
	}

	public set promiseId( value: number ) {
		this._promiseId = value;
	}

	public get asset(): object|null {
		return this._asset ?? null;
	}

	public set asset( value: object ) {
		this._asset = value;
	}

	public get source(): object|null {
		return this._source ?? null;
	}

	public set source( value: object ) {
		this._source = value;
	}

	public get quantity(): object|null {
		return this._quantity ?? null;
	}

	public set quantity( value: object ) {
		this._quantity = value;
	}

	public get promiseMeta(): object|null {
		return this._promiseMeta ?? null;
	}

	public set promiseMeta( value: object ) {
		this._promiseMeta = value;
	}

	public get tokenMeta(): object|null {
		return this._tokenMeta ?? null;
	}

	public set tokenMeta( value: object ) {
		this._tokenMeta = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.source_id ) {
			data.sourceId = data.source_id;
			delete data.source_id;
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at;
			delete data.created_at;
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at;
			delete data.updated_at;
		}
		if ( data.promise_id ) {
			data.promiseId = data.promise_id;
			delete data.promise_id;
		}
		if ( data.promise_meta ) {
			data.promiseMeta = data.promise_meta;
			delete data.promise_meta;
		}
		if ( data.token_meta ) {
			data.tokenMeta = data.token_meta;
			delete data.token_meta;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'sourceId',
			'destination',
			'fingerprint',
			'txid',
			'createdAt',
			'updatedAt',
			'expiration',
			'ref',
			'pseudo',
			'note',
			'protocol',
			'chain',
			'promiseId',
			'asset',
			'source',
			'quantity',
			'promiseMeta',
			'tokenMeta',
		] );
	}
}