<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

interface SourceControllerInterface extends ControllerInterface {
	public function index( SourceCollectionInterface $sources, \WP_REST_Request $request );
	public function show( SourceInterface $source, \WP_REST_Request $request );
	public function store( \WP_REST_Request $request );
	public function update( SourceInterface $source, \WP_REST_Request $request );
	public function destroy( SourceInterface $source, \WP_REST_Request $request );
}
