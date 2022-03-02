<?php

namespace Tokenly\Wp\Collections\Routes\Listings;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Routes\Listings\ActionCollectionInterface;

use Tokenly\Wp\Models\Routes\Listings\Action;

class ActionCollection extends Collection implements ActionCollectionInterface {
	protected string $item_type = Action::class;
}
