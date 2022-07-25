<?php

namespace Tokenly\Wp\Presentation\Views\Web;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\UserViewModelInterface;

use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;

class UserViewModel extends ViewModel implements UserViewModelInterface {
	protected UserRepositoryInterface $user_repository;
	
	public function __construct(
		UserRepositoryInterface $user_repository
	) {
		$this->user_repository = $user_repository;
	}
	
	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) && !empty( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		$user = $this->user_repository->show( array(
			'id' => $user_id,
		) );
		$can_connect = false;
		if ( $user != null ) {
			$can_connect = $user->can_connect;
		}
		return array(
			'user_id'     => $user_id,
			'can_connect' => $can_connect,
		);
	}
}
