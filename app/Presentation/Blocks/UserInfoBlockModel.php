<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;

class UserInfoBlockModel extends BlockModel implements UserInfoBlockModelInterface {
	public function prepare( array $data = array() ) {
		$view_data = array();
		$user = $data['user'] ?? null;
		$html = '';
		if ( $user ) {
			$name = $user->user_nicename;
			$view_data['name'] = $name;
		}
		return $view_data;
	}
}
