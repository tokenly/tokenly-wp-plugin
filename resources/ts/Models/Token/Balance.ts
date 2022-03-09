import Model from '../Model';
import BalanceInterface from '../../Interfaces/Models/Token/BalanceInterface';

export default class Balance extends Model implements BalanceInterface {
	protected _name?: string = null;
	protected _precision?: number = null;
	protected _asset?: object = null;
	protected _quantity?: number = null;
	protected _meta?: object = null;

	public get name(): string|null {
		return this._name ?? null;
	}

	public set name( value: string ) {
		this._name = value;
	}

	public get precision(): number|null {
		return this._precision ?? null;
	}

	public set precision( value: number ) {
		this._precision = value;
	}

	public get asset(): object|null {
		return this._asset ?? null;
	}

	public set asset( value: object ) {
		this._asset = value;
	}

	public get quantity(): number|null {
		return this._quantity ?? null;
	}

	public set quantity( value: number ) {
		this._quantity = value;
	}

	public get meta(): object|null {
		return this._meta ?? null;
	}

	public set meta( value: object ) {
		this._meta = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'name',
			'precision',
			'asset',
			'quantity',
			'meta',
		] );
	}
}