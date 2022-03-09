import Model from '../Model';
import AccountHistoryInterface from '../../Interfaces/Models/Credit/AccountHistoryInterface';

export default class AccountHistory extends Model implements AccountHistoryInterface {
	protected _count?: number = null;
	protected _account?: object = null;
	protected _transactions?: object = null;

	public get count(): number|null {
		return this._count ?? null;
	}

	public set count( value: number ) {
		this._count = value;
	}

	public get account(): object|null {
		return this._account ?? null;
	}

	public set account( value: object ) {
		this._account = value;
	}

	public get transactions(): object|null {
		return this._transactions ?? null;
	}

	public set transactions( value: object ) {
		this._transactions = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'count',
			'account',
			'transactions',
		] );
	}
}