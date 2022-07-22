import Model from '../Model'
import SourceInterface from '../../Interfaces/Models/Token/SourceInterface'
import AddressInterface from '../../Interfaces/Models/Token/AddressInterface'
import BalanceCollectionInterface from '../../Interfaces/Collections/Token/BalanceCollectionInterface'

export default class Source extends Model implements SourceInterface {
	public addressId?: string = null
	public assets?: Array<string> = null
	public type?: string = null
	public address?: AddressInterface = null

	public fromJson( data: any = {} ): this {
		if ( data?.address_id ) {
			data.addressId = data.address_id
			delete data.address_id
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'addressId',
			'assets',
			'type',
			'address',
		] )
	}
}