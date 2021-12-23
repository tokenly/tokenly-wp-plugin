<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Credit;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupIndexViewModelInterface;

use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface;

class GroupIndexViewModel extends ViewModel implements GroupIndexViewModelInterface {
	protected $group_service;
	
	public function __construct(
		GroupServiceInterface $group_service
	) {
		$this->group_service = $group_service;
	}
	
	public function prepare( array $data = array() ) {
		$groups = $this->group_service->index();
		if ( $groups && is_object( $groups ) ) {
			$groups = $groups->to_array();
		} else {
			$groups = array();
		}
		return array(
			'credit_groups' => $groups,
		);
	}
}
