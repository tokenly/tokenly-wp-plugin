<?php

namespace Tokenly\Wp\Interfaces\Controllers\Api\Token;

use Tokenly\Wp\Interfaces\Controllers\ControllerInterface;

use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface;

interface SourceControllerInterface extends ControllerInterface {
	public function index( \WP_REST_Request $request, SourceCollectionInterface $sources ): array;
	public function show( \WP_REST_Request $request, SourceInterface $source ): ?array;
	public function store( \WP_REST_Request $request ): void;
	public function update( \WP_REST_Request $request, SourceInterface $source ): void;
	public function destroy( \WP_REST_Request $request, SourceInterface $source ): void;
}
