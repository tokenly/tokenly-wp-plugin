import Post from '../Post'
import MetaInterface from '../../Interfaces/Models/Token/MetaInterface'

export default class Meta extends Post implements MetaInterface {
	public assetName?: string = null
	public attributes?: object = null
	public media?: object = null
	public blockchain?: string = null
	public protocol?: string = null
	public slug?: string = null
	public asset?: object = null

	public fromJson( data: any = {} ): this {
		if ( data.asset_name ) {
			data.assetName = data.asset_name
			delete data.asset_name
		}
		return super.fromJson( data )
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
		] )
	}
}