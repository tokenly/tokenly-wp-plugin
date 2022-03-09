import Model from '../Model';
import QuantityInterface from '../../Interfaces/Models/Token/QuantityInterface';

export default class Quantity extends Model implements QuantityInterface {
	protected value?: number = null;
	protected valueSat?: number = null;
	protected precision?: number = null;

	public fromJson( data: any = {} ): this {
		if ( data.value_sat ) {
			data.valueSat = data.value_sat;
			delete data.value_sat;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'value',
			'valueSat',
			'precision',
		] );
	}
}