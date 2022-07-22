import Post from '../Post'
import PromiseMetaInterface
	from '../../Interfaces/Models/Token/PromiseMetaInterface'
import UserInterface from '../../Interfaces/Models/UserInterface'
import User from '../User'

export default class PromiseMeta extends Post implements PromiseMetaInterface {
	public promiseId?: number = null
	public sourceUserId?: string = null
	public sourceUser?: UserInterface = null
	public destinationUserId?: string = null
	public destinationUser?: UserInterface = null

	public fromJson( data: any = {} ): this {
		if ( data.promise_id ) {
			data.promiseId = data.promise_id
			delete data.promise_id
		}
		if ( data.source_user_id ) {
			data.sourceUserId = data.source_user_id
			delete data.source_user_id
		}
		if ( data.source_user ) {
			data.sourceUser =
				( new User() ).fromJson( data.source_user )
			delete data.source_user
		}
		if ( data.destination_user_id ) {
			data.destinationUserId = data.destination_user_id
			delete data.destination_user_id
		}
		if ( data.destination_user ) {
			data.destinationUser =
				( new User() ).fromJson( data.destination_user )
			delete data.destination_user
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'promiseId',
			'sourceUserId',
			'sourceUser',
			'destinationUserId',
			'destinationUser',
		] )
	}
}