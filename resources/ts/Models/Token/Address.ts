import Model from '../Model';
import AddressInterface from '../../Interfaces/Models/Token/AddressInterface';

export default class Address extends Model implements AddressInterface {
	public address?: string = null;
	public type?: string = null;
	public label?: string = null;
	public public?: boolean = null;
	public active?: boolean = null;
	public verified?: boolean = null;
	public verifyCode?: string = null;
	public balance?: object = null;

	public fromJson( data: any = {} ): this {
		if ( data.verify_code ) {
			data.verifyCode = data.verify_code;
			delete data.verify_code;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'address',
			'type',
			'label',
			'public',
			'active',
			'verified',
			'verifyCode',
		] );
	}
}