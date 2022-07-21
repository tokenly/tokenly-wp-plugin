import Model from '../Model';
import TransactionReportInterface from '../../Interfaces/Models/Credit/TransactionReportInterface';

export default class TransactionReport extends Model implements TransactionReportInterface {
	public credit?: object = null;
	public debit?: object = null;

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'credit',
			'debit',
		] );
	}
}