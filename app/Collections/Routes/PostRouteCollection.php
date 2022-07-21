<?php

namespace Tokenly\Wp\Collections\Routes;

use Tokenly\Wp\Collections\Routes\RouteCollection;
use Tokenly\Wp\Interfaces\Collections\Routes\PostRouteCollectionInterface;

use Tokenly\Wp\Models\Routes\PostRoute;

class PostRouteCollection extends RouteCollection
	implements PostRouteCollectionInterface
{
	protected string $item_type = PostRoute::class;
}
