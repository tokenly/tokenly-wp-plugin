import Model from '../Model';
import GroupHistoryInterface from '../../Interfaces/Models/Credit/GroupHistoryInterface';

export default class GroupHistory extends Model implements GroupHistoryInterface {
	protected _balance?: object = null;
	protected _count?: number = null;
	protected _transactions?: object = null;

	public get balance(): object|null {
		return this._balance ?? null;
	}

	public set balance( value: object ) {
		this._balance = value;
	}

	public get count(): number|null {
		return this._count ?? null;
	}

	public set count( value: number ) {
		this._count = value;
	}

	public get transactions(): object|null {
		return this._transactions ?? null;
	}

	public set transactions( value: object ) {
		this._transactions = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'balance',
			'count',
			'transactions',
		] );
	}
}