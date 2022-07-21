<?php

namespace Tokenly\Wp\Collections\Routes;

use Tokenly\Wp\Collections\Routes\RouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\AdminRouteCollectionInterface;

use Tokenly\Wp\Models\Routes\AdminRoute;

class AdminRouteCollection extends RouteCollection
	implements AdminRouteCollectionInterface
{
	protected string $item_type = AdminRoute::class;
}
