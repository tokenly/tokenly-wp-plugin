import Post from '../Post';
import PromiseMetaInterface from '../../Interfaces/Models/Token/PromiseMetaInterface';

export default class PromiseMeta extends Post implements PromiseMetaInterface {
	protected promiseId?: number = null;
	protected sourceUserId?: number = null;
	protected sourceUser?: object = null;
	protected destinationUserId?: number = null;
	protected destinationUser?: object = null;

	public fromJson( data: any = {} ): this {
		if ( data.promise_id ) {
			data.promiseId = data.promise_id;
			delete data.promise_id;
		}
		if ( data.source_user_id ) {
			data.sourceUserId = data.source_user_id;
			delete data.source_user_id;
		}
		if ( data.source_user ) {
			data.sourceUser = data.source_user;
			delete data.source_user;
		}
		if ( data.destination_user_id ) {
			data.destinationUserId = data.destination_user_id;
			delete data.destination_user_id;
		}
		if ( data.destination_user ) {
			data.destinationUser = data.destination_user;
			delete data.destination_user;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'promiseId',
			'sourceUserId',
			'sourceUser',
			'destinationUserId',
			'destinationUser',
		] );
	}
}