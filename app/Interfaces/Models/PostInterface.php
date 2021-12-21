<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\ModelInterface;

use Tokenly\Wp\Interfaces\Models\UserInterface;

interface PostInterface extends ModelInterface {
	public function can_access( UserInterface $user );
}
