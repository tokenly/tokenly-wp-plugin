import Model from '../Model'
import TransactionInterface from '../../Interfaces/Models/Credit/TransactionInterface'

export default class Transaction extends Model implements TransactionInterface {
	public txUuid?: string = null
	public creditGroup?: string = null
	public account?: string = null
	public accountUuid?: string = null
	public amount?: string = null
	public oauthUserId?: string = null
	public ref?: string = null
	public createdAt?: string = null
	public updatedAt?: string = null

	public fromJson( data: any = {} ): this {
		if ( data.tx_uuid ) {
			data.txUuid = data.tx_uuid
			delete data.tx_uuid
		}
		if ( data.credit_group ) {
			data.creditGroup = data.credit_group
			delete data.credit_group
		}
		if ( data.account_uuid ) {
			data.accountUuid = data.account_uuid
			delete data.account_uuid
		}
		if ( data.oauth_user_id ) {
			data.oauthUserId = data.oauth_user_id
			delete data.oauth_user_id
		}
		if ( data.created_at ) {
			data.createdAt = data.created_at
			delete data.created_at
		}
		if ( data.updated_at ) {
			data.updatedAt = data.updated_at
			delete data.updated_at
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'txUuid',
			'creditGroup',
			'account',
			'accountUuid',
			'amount',
			'oauthUserId',
			'ref',
			'createdAt',
			'updatedAt',
		] )
	}
}