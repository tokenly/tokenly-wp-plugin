import ModelInterface from '../ModelInterface'

export default interface GroupHistoryInterface extends ModelInterface {
	balance?: object
	count?: number
	transactions?: object
}