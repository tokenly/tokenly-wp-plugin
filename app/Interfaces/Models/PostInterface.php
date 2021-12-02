<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\UserInterface;

interface PostInterface {
	public function can_access_post( UserInterface $user );
}
