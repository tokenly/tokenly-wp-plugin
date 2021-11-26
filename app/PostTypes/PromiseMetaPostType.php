<?php

namespace Tokenly\Wp\PostTypes;

class PromiseMetaPostType {
	public function get_args() {
		$labels = array(
			'name'                  => _x( 'Promise Meta', 'Post type general name', 'tokenly-wp-plugin' ),
		);
	 
		$args = array(
			'labels'             => $labels,
			//
		);

		return $args;
	}
}
