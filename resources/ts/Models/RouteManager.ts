import Model from './Model'
import RouteManagerInterface from '../Interfaces/Models/RouteManagerInterface'
import RouteCollectionInterface from '../Interfaces/Collections/RouteCollectionInterface'
import RouteCollection from '../Collections/RouteCollection'

export default class RouteManager extends Model implements RouteManagerInterface {
	protected namespace: string
	public admin?: RouteCollectionInterface = null
	public api?: RouteCollectionInterface = null
	public post?: RouteCollectionInterface = null
    public term?: RouteCollectionInterface = null
    public web?: RouteCollectionInterface = null

	constructor( namespace: string ) {
		super()
		this.namespace = namespace
	}

	public fromJson( data: any = {} ): this {
		if ( data.admin ) {
			data.admin = ( new RouteCollection() ).fromJson( data.admin )
		}
        if ( data.api ) {
			data.api = ( new RouteCollection() ).fromJson( data.api )
		}
        if ( data.post ) {
			data.post = ( new RouteCollection() ).fromJson( data.post )
		}
        if ( data.term ) {
			data.term = ( new RouteCollection() ).fromJson( data.term )
		}
        if ( data.web ) {
			data.web = ( new RouteCollection() ).fromJson( data.web )
		}
		return super.fromJson( data )
	}

	public get( type: string, route: string, params: any = {} ): string {
		let key = route
		if ( type == 'admin' ) {
			key = `${this.namespace}_${route}`
		}
		const searchParams = new URLSearchParams(params).toString()
		const path = `${this[ type ].get( key ).url}&${searchParams}`
		return path
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'admin',
			'api',
			'post',
            'term',
			'web',
		] )
	}
}
