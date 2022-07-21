import Model from '../Model';
import AccountInterface from '../../Interfaces/Models/Credit/AccountInterface';
import GroupInterface from '../../Interfaces/Models/Credit/GroupInterface';

export default class Account extends Model implements AccountInterface {
	public name?: string = null;
	public uuid?: string = null;
	public balance?: number = null;
	public oauthUser?: string = null;
	public createdAt?: string = null;
	public updatedAt?: string = null;
	public groupId?: string = null;
	public group?: GroupInterface;

	public fromJson( data: any = {} ): this {
		if ( data.oauth_user ) {
			data.oauthUser = data.oauth_user;
			delete data.oauth_user;
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at;
			delete data.created_at;
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at;
			delete data.updated_at;
		}
		if ( data.group_id ) {
			data.groupId = data.group_id;
			delete data.group_id;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'name',
			'uuid',
			'balance',
			'oauthUser',
			'createdAt',
			'updatedAt',
			'groupId',
		] );
	}
}