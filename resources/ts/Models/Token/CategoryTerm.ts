import Term from '../Term';
import CategoryTermInterface from '../../Interfaces/Models/Token/CategoryTermInterface';

export default class CategoryTerm extends Term implements CategoryTermInterface {
	public image?: object = null;
	public media?: object = null;

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'image',
			'media',
		] );
	}
}