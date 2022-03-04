<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

interface SourceControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, SourceCollectionInterface $sources ): \WP_REST_Response;
	public function show( \WP_REST_Request $request, SourceInterface $source ): \WP_REST_Response;
	public function store( \WP_REST_Request $request ): \WP_REST_Response;
	public function update( \WP_REST_Request $request, SourceInterface $source ): \WP_REST_Response;
	public function destroy( \WP_REST_Request $request, SourceInterface $source ): \WP_REST_Response;
}
