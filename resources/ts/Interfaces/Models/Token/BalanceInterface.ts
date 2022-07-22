import ModelInterface from '../ModelInterface'

export default interface BalanceInterface extends ModelInterface {
	name?: string
	precision?: number
	asset?: object
	quantity?: number
	meta?: object
}