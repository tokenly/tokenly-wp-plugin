import Collection from './Collection'
import RouteCollectionInterface from '../Interfaces/Collections/RouteCollectionInterface'
import Route from '../Models/Route'

export default class RouteCollection extends Collection
	implements RouteCollectionInterface
{
	protected class = Route
}
