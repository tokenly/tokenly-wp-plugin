<?php

/**
 * Collection of Address objects
 */

namespace Tokenly\Wp\Collections;

use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Collections\Collection;

class AddressCollection extends Collection implements AddressCollectionInterface {
	protected $item_type = AddressInterface::class;
}
