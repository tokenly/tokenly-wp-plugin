<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;

class UserInfoBlockModel extends BlockModel implements UserInfoBlockModelInterface {
	public function prepare( array $data = array() ) {
		$name = null;
		if ( isset( $data['user'] ) ) {
			$user =  $data['user'];
			$name = $user->user_nicename;
		}
		return array(
			'name' => $name,
		);
	}
}
