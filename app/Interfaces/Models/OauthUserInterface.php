<?php

namespace Tokenly\Wp\Interfaces\Models;

use Tokenly\Wp\Interfaces\Models\OauthUserInterface;
use Tokenly\Wp\Interfaces\Models\ModelInterface;

interface OauthUserInterface extends ModelInterface {
	public function can_social_login();
}
