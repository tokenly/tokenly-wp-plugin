import Model from './Model'
import RouteInterface from '../Interfaces/Models/RouteInterface'

export default class Route extends Model implements RouteInterface {
	public name?: string = null
	public url?: string = null
	public access?: boolean = null

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'name',
			'url',
			'access',
		] )
	}
}
