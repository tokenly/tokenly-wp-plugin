<?php

namespace Tokenly\Wp\Collections\Routes;

use Tokenly\Wp\Collections\Routes\RouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\ApiRouteCollectionInterface;

use Tokenly\Wp\Models\Routes\ApiRoute;

class ApiRouteCollection extends RouteCollection implements ApiRouteCollectionInterface {
	protected string $item_type = ApiRoute::class;
}
