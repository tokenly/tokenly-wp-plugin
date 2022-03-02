<?php

namespace Tokenly\Wp\Presentation\Blocks;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class UserInfoBlockModel extends BlockModel implements UserInfoBlockModelInterface {
	protected UserRepositoryInterface $user_repository;

	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): ?array {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		$user = $this->user_repository->show( array(
			'id' => $user_id,
		) );
		if ( !$user ) {
			return null;
		}
		$user = $user->to_array();
		return array(
			'user' => array(
				'id'          => $user['id'],
				'name'        => $user['name_display'],
				'description' => $user['description'],
				'avatar'      => $user['avatar'],
			),
		);
	}
}
