<?php
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseMetaRepositoryInterface;

return function(
	string $text_domain,
	PromiseMetaRepositoryInterface $repository
) {
	$labels = array(
		'name' => _x( 'Promise Meta', 'Post type general name', $text_domain ),
	);
	$args = array(
		'labels'     => $labels,
		'repository' => $repository,
	);
	return $args;
};
