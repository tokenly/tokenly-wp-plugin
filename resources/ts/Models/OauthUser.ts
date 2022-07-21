import Model from './Model';
import OauthUserInterface from '../Interfaces/Models/OauthUserInterface';

export default class OauthUser extends Model implements OauthUserInterface {
	public id?: string = null;
	public username?: string = null;
	public address?: object;
	public creditAccount?: object;
	public balance?: object;
	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'username',
			'address',
			'creditAccount',
			'balance',
		] );
	}

	public fromJson( data: any = {} ): this {
		if ( data.credit_account ) {
			data.creditAccount = data.credit_account;
			delete data.credit_account;
		}
		return super.fromJson( data );
	}
}