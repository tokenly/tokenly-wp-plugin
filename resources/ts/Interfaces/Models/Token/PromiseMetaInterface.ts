import PostInterface from '../PostInterface'
import UserInterface from '../UserInterface';

export default interface PromiseMetaInterface extends PostInterface {
	promiseId?: number
	sourceUserId?: string
	sourceUser?: UserInterface
	destinationUserId?: string
	destinationUser?: UserInterface
}