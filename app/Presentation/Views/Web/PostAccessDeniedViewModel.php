<?php

namespace Tokenly\Wp\Presentation\Views\Web;

use Tokenly\Wp\Presentation\Views\ViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;

class PostAccessDeniedViewModel extends ViewModel implements PostAccessDeniedViewModelInterface {
	public function prepare( array $data = array() ) {
		$view_data = array(
			'back_url' => $_SERVER['HTTP_REFERER'] ?? '/',
		);
		if ( isset( $data['rules'] ) ) {
			foreach ( $data['rules'] as &$rule_group ) {
				$rule_group = $rule_group->to_array();
			}
			$view_data['rule_groups'] = $data['rules'];
		}
		if ( isset( $data['verdict'] ) ) {
			$verdict = $data['verdict'];
			$verdict = $verdict->to_array();
			if ( isset( $verdict['reports'] ) ) {
				$verdict['note'] = "Please, make sure you can pass the following requirements:";
				$reports = $verdict['reports'];
				$reports_formatted = array();
				foreach ( $reports as $report ) {
					$status = $report['status'] ? 'Passed' : 'Failed';
					$reports_formatted[ $report['hash'] ] = $status;
				}
				$verdict['reports'] = $reports_formatted;
			}
			$view_data['verdict'] = $verdict;
		}
		return $view_data;
	}
}
