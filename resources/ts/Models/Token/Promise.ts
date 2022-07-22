import Model from '../Model'
import PromiseInterface from '../../Interfaces/Models/Token/PromiseInterface'

import MetaInterface from '../../Interfaces/Models/Token/MetaInterface'
import PromiseMetaInterface from '../../Interfaces/Models/Token/PromiseMetaInterface'
import SourceInterface from '../../Interfaces/Models/Token/SourceInterface'
import QuantityInterface from '../../Interfaces/Models/Token/QuantityInterface'
import AssetInterface from '../../Interfaces/Models/Token/AssetInterface'
import PromiseMeta from './PromiseMeta'
import Meta from './Meta'
import Quantity from './Quantity'

export default class Promise extends Model implements PromiseInterface {
	public sourceId?: string = null
	public destination?: string = null
	public fingerprint?: string = null
	public txid?: string = null
	public createdAt?: string = null
	public updatedAt?: string = null
	public expiration?: string = null
	public ref?: string = null
	public pseudo?: boolean = null
	public note?: string = null
	public protocol?: string = null
	public chain?: string = null
	public promiseId?: number = null
	public asset?: AssetInterface = null
	public source?: SourceInterface = null
	public quantity?: QuantityInterface = null
	public promiseMeta?: PromiseMetaInterface = null
	public tokenMeta?: MetaInterface = null

	public fromJson( data: any = {} ): this {
		if ( data.source_id ) {
			data.sourceId = data.source_id
			delete data.source_id
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at
			delete data.created_at
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at
			delete data.updated_at
		}
		if ( data.promise_id ) {
			data.promiseId = data.promise_id
			delete data.promise_id
		}
		if ( data.quantity ) {
			data.quantity = ( new Quantity() ).fromJson( data.quantity )
		}
		if ( data.promise_meta ) {
			data.promiseMeta = 
				( new PromiseMeta() ).fromJson( data.promise_meta )
			delete data.promise_meta
		}
		if ( data.token_meta ) {
			data.tokenMeta = ( new Meta() ).fromJson( data.token_meta )
			delete data.token_meta
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'sourceId',
			'destination',
			'fingerprint',
			'txid',
			'createdAt',
			'updatedAt',
			'expiration',
			'ref',
			'pseudo',
			'note',
			'protocol',
			'chain',
			'promiseId',
			'asset',
			'source',
			'quantity',
			'promiseMeta',
			'tokenMeta',
		] )
	}
}