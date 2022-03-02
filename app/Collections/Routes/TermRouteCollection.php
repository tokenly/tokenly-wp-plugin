<?php

namespace Tokenly\Wp\Collections\Routes;

use Tokenly\Wp\Collections\Routes\RouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\TermRouteCollectionInterface;

use Tokenly\Wp\Models\Routes\TermRoute;

class TermRouteCollection extends RouteCollection implements TermRouteCollectionInterface {
	protected string $item_type = TermRoute::class;
}
