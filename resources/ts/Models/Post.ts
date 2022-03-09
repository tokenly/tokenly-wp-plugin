import Model from './Model';
import PostInterface from '../Interfaces/Models/PostInterface';
import ProtectableInterface from '../Interfaces/Mixins/ProtectableInterface';

export default class Post extends Model implements PostInterface, ProtectableInterface {
	protected _id?: number = null;
	protected _name?: string = null;
	protected _description?: string = null;
	protected _image?: string = null;

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

	public get description(): string|null {
		return this._description ?? null;
	}

	public set description( value: string ) {
		this._description = value;
	}

	public get image(): string|null {
		return this._image ?? null;
	}

	public set image( value: string ) {
		this._image = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'name',
			'description',
			'image',
		] );
	}
}
