<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\ModelInterface;

interface PostInterface extends ModelInterface {
	public function can_access_post( UserInterface $user );
}
