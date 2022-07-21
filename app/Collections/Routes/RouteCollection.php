<?php

namespace Tokenly\Wp\Collections\Routes;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Routes\RouteCollectionInterface;

use Tokenly\Wp\Interfaces\Models\Routes\Route;

class RouteCollection extends Collection
	implements RouteCollectionInterface
{
	protected string $item_type = Route::class;
}
