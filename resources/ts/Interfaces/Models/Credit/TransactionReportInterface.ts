import ModelInterface from '../ModelInterface'

export default interface TransactionReportInterface extends ModelInterface {
	credit?: object
	debit?: object
}