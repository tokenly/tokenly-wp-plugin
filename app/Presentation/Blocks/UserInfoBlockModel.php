<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;

class UserInfoBlockModel extends BlockModel implements UserInfoBlockModelInterface {
	public function __construct(
		UserServiceInterface $user_service
	) {
		$this->user_service = $user_service;
	}

	public function prepare( array $data = array() ) {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		$user = $this->user_service->show( array(
			'id' => $user_id,
		) );
		if ( !$user ) {
			return;
		}
		$user->load( array( 'oauth_user' ) );
		if ( !isset( $user->oauth_user ) ) {
			return;
		}
		$user = $user->to_array();
		return array(
			'user' => array(
				'name' => $user['name'],
			),
		);
	}
}
