import AddressEditInterface from '../../Interfaces/Models/Token/AddressEditInterface';

export default class AddressEdit implements AddressEditInterface {
	public address?: string;
	public label?: string;
	public public?: boolean;
	public active?: boolean;
	public type?: string;

	// public fromAddress( AddressInterface: address ): this {
	// 	address: addressFound?.address,
	// 	label: addressFound?.label,
	// 	public: addressFound?.public,
	// 	active: addressFound?.active,
	// 	type: addressFound?.type,
	// }

	// protected get fillable(): Array<string> {
	// 	return super.fillable.concat( [
	// 		'address',
	// 		'type',
	// 		'label',
	// 		'public',
	// 		'active',
	// 		'verified',
	// 		'verifyCode',
	// 	] );
	// }
}