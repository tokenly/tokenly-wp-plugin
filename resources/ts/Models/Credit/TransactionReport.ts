import Model from '../Model';
import TransactionReportInterface from '../../Interfaces/Models/Credit/TransactionReportInterface';

export default class TransactionReport extends Model implements TransactionReportInterface {
	protected _credit?: object = null;
	protected _debit?: object = null;

	public get credit(): object|null {
		return this._credit ?? null;
	}

	public set credit( value: object ) {
		this._credit = value;
	}

	public get debit(): object|null {
		return this._debit ?? null;
	}

	public set debit( value: object ) {
		this._debit = value;
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'credit',
			'debit',
		] );
	}
}