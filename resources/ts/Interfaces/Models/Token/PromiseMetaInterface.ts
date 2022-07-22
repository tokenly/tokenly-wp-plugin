import PostInterface from '../PostInterface'

export default interface PromiseMetaInterface extends PostInterface {
	promiseId?: number
	sourceUserId?: string
	sourceUser?: object
	destinationUserId?: string
	destinationUser?: object
}