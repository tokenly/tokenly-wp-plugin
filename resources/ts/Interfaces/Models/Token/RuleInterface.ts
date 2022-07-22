import ModelInterface from '../ModelInterface'

export default interface RuleInterface extends ModelInterface {
	asset?: string
	quantity?: number
	op?: string
	stackOp?: string
}