import Model from './Model';
import PostInterface from '../Interfaces/Models/PostInterface';
import ProtectableInterface from '../Interfaces/Mixins/ProtectableInterface';

export default class Post extends Model implements PostInterface, ProtectableInterface {
	public id?: number = null;
	public name?: string = null;
	public description?: string = null;
	public image?: string = null;

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'name',
			'description',
			'image',
		] );
	}
}
