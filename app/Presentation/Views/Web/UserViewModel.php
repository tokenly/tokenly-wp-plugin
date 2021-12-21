<?php

namespace Tokenly\Wp\Presentation\Views\Web;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\UserViewModelInterface;

class UserViewModel extends ViewModel implements UserViewModelInterface {

	public function prepare( array $data = array() ) {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		return array(
			'user_id' => $user_id,
		);
	}
}
