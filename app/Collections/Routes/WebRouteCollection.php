<?php

namespace Tokenly\Wp\Collections\Routes;

use Tokenly\Wp\Collections\Routes\RouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\WebRouteCollectionInterface;

use Tokenly\Wp\Models\Routes\WebRoute;

class WebRouteCollection extends RouteCollection implements WebRouteCollectionInterface {
	protected string $item_type = WebRoute::class;
}
