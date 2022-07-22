import ModelInterface from './ModelInterface'

export default interface RouteManagerInterface extends ModelInterface {
	get( type: string, route: string, params?: any ): string
}