import Term from '../Term';
import CategoryTermInterface from '../../Interfaces/Models/Token/CategoryTermInterface';

export default class CategoryTerm extends Term implements CategoryTermInterface {
	protected _image?: object = null;
	protected _media?: object = null;

	public get image(): object|null {
		return this._image ?? null;
	}

	public set image( value: object ) {
		this._image = value;
	}

	public get media(): object|null {
		return this._media ?? null;
	}

	public set media( value: object ) {
		this._media = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'image',
			'media',
		] );
	}
}