import Model from './Model'
import TermInterface from '../Interfaces/Models/TermInterface'
import ProtectableInterface from '../Interfaces/Mixins/ProtectableInterface'

export default class Term extends Model implements TermInterface, ProtectableInterface {
	public id?: number = null
	public name?: string = null
	public description?: string = null
	public slug?: string = null
	public link?: string = null

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'name',
			'description',
			'slug',
			'link',
		] )
	}
}