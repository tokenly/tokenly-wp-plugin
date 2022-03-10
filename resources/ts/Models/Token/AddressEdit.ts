import AddressEditInterface from '../../Interfaces/Models/Token/AddressEditInterface';

export default class AddressEdit implements AddressEditInterface {
	protected _address?: string;
	protected _label?: string;
	protected _public?: boolean;
	protected _active?: boolean;
	protected _type?: string;

	public get address(): string|null {
		return this._address ?? null;
	}

	public set address( value: string ) {
		this._address = value;
	}

	public get label(): string|null {
		return this._label ?? null;
	}

	public set label( value: string ) {
		this._label = value;
	}

	public get public(): boolean|null {
		return this._public ?? null;
	}

	public set public( value: boolean ) {
		this._public = value;
	}

	public get public(): boolean|null {
		return this._public ?? null;
	}

	public set public( value: boolean ) {
		this._public = value;
	}

	public fromAddress( AddressInterface: address ): this {
		address: addressFound?.address,
		label: addressFound?.label,
		public: addressFound?.public,
		active: addressFound?.active,
		type: addressFound?.type,
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