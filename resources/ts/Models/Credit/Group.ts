import Model from '../Model';
import GroupInterface from '../../Interfaces/Models/Credit/GroupInterface';

export default class Group extends Model implements GroupInterface {
	public name?: string = null;
	public uuid?: string = null;
	public active?: boolean = null;
	public appWhitelist?: object = null;
	public createdAt?: string = null;
	public updatedAt?: string = null;

	public fromJson( data: any = {} ): this {
		if ( data.app_whitelist ) {
			data.appWhitelist = data.app_whitelist;
			delete data.app_whitelist;
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at;
			delete data.created_at;
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at;
			delete data.updated_at;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'name',
			'uuid',
			'active',
			'appWhitelist',
			'createdAt',
			'updatedAt',
		] );
	}
}
