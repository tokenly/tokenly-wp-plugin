import ModelInterface from './ModelInterface'

export default interface RouteInterface extends ModelInterface {
	name?: string
	url?: string
	access?: boolean
}