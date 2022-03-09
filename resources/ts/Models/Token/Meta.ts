import Post from '../Post';
import MetaInterface from '../../Interfaces/Models/Token/MetaInterface';

export default class Meta extends Post implements MetaInterface {
	protected _assetName?: string = null;
	protected _attributes?: object = null;
	protected _media?: object = null;
	protected _blockchain?: string = null;
	protected _protocol?: string = null;
	protected _slug?: string = null;
	protected _asset?: object = null;

	public get assetName(): string|null {
		return this._assetName ?? null;
	}

	public set assetName( value: string ) {
		this._assetName = value;
	}

	public get attributes(): object|null {
		return this._attributes ?? null;
	}

	public set attributes( value: object ) {
		this._attributes = value;
	}

	public get media(): object|null {
		return this._media ?? null;
	}

	public set media( value: object ) {
		this._media = value;
	}

	public get blockchain(): string|null {
		return this._blockchain ?? null;
	}

	public set blockchain( value: string ) {
		this._blockchain = value;
	}

	public get protocol(): string|null {
		return this._protocol ?? null;
	}

	public set protocol( value: string ) {
		this._protocol = value;
	}

	public get slug(): string|null {
		return this._slug ?? null;
	}

	public set slug( value: string ) {
		this._slug = value;
	}

	public get asset(): object|null {
		return this._asset ?? null;
	}

	public set asset( value: object ) {
		this._asset = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.asset_name ) {
			data.assetName = data.asset_name;
			delete data.asset_name;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'assetName',
			'attributes',
			'media',
			'blockchain',
			'protocol',
			'slug',
			'asset',
		] );
	}
}