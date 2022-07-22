import Model from '../Model'
import RuleInterface from '../../Interfaces/Models/Token/RuleInterface'

export default class Rule extends Model implements RuleInterface {
	public asset?: string = null
	public quantity?: number = null
	public op?: string = null
	public stackOp?: string = null

	public fromJson( data: any = {} ): this {
		if ( data.stack_op ) {
			data.stackOp = data.stack_op
			delete data.stack_op
		}
		return super.fromJson( data )
	}

	public toJson(): any {
		const json: any = Object.assign( {} , this )
		delete json.stackOp
		json.stack_op = this.stackOp
		return json
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'asset',
			'quantity',
			'op',
			'stackOp',
		] )
	}
}