import Model from '../Model';
import RuleInterface from '../../Interfaces/Models/Token/RuleInterface';

export default class Rule extends Model implements RuleInterface {
	public asset?: string = null;
	public quantity?: number = null;
	public op?: string = null;
	public stackOp?: string = null;

	public fromJson( data: any = {} ): this {
		if ( data.stack_op ) {
			data.stackOp = data.stack_op;
			delete data.stack_op;
		}
		return super.fromJson( data );
	}

	public toJson(): any {
		return {
			...( this.asset ) && { asset: this.asset },
			...( this.quantity ) && { quantity: this.quantity },
			...( this.op ) && { op: this.op },
			...( this.stackOp ) && { stack_op: this.stackOp },
		}
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'asset',
			'quantity',
			'op',
			'stackOp',
		] );
	}
}