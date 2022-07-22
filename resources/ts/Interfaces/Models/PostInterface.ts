import ModelInterface from './ModelInterface'

export default interface PostInterface extends ModelInterface {
	id?: number
	name?: string
	description?: string
	image?: string
}