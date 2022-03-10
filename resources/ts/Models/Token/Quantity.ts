import Model from '../Model';
import QuantityInterface from '../../Interfaces/Models/Token/QuantityInterface';

export default class Quantity extends Model implements QuantityInterface {
	protected _value?: number = null;
	protected _valueSat?: number = null;
	protected _precision?: number = null;

	public get value(): number|null {
		return this._value ?? null;
	}

	public set value( value: number ) {
		this._value = value;
	}

	public get valueSat(): number|null {
		return this._valueSat ?? null;
	}

	public set valueSat( value: number ) {
		this._valueSat = value;
	}

	public get precision(): number|null {
		return this._precision ?? null;
	}

	public set precision( value: number ) {
		this._precision = value;
	}

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