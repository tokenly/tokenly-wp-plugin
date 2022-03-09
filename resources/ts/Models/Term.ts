import Model from './Model';
import TermInterface from '../Interfaces/Models/TermInterface';
import ProtectableInterface from '../Interfaces/Mixins/ProtectableInterface';

export default class Term extends Model implements TermInterface, ProtectableInterface {
	protected _id?: number = null;
	protected _name?: string = null;
	protected _description?: string = null;
	protected _slug?: string = null;
	protected _link?: string = null;

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

	public get slug(): string|null {
		return this._slug ?? null;
	}

	public set slug( value: string ) {
		this._slug = value;
	}

	public get link(): string|null {
		return this._link ?? null;
	}

	public set link( value: string ) {
		this._link = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'name',
			'description',
			'slug',
			'link',
		] );
	}
}