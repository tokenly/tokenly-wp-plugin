<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\TermRepository;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;

use Tokenly\Wp\Collections\Token\CategoryTermCollection;
use Tokenly\Wp\Models\Token\CategoryTerm;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\CategoryTermInterface;
use Tokenly\Wp\Interfaces\Repositories\General\TermMetaRepositoryInterface;

/**
 * Manages Category Terms
 */
class CategoryTermRepository extends TermRepository implements CategoryTermRepositoryInterface {
	protected string $class = CategoryTerm::class;
	protected string $class_collection = CategoryTermCollection::class;
	protected string $namespace;

	public function __construct(
		TermMetaRepositoryInterface $term_meta_repository,
		string $namespace
	) {
		parent::__construct( $term_meta_repository );
		$this->namespace = $namespace;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_meta_fields(): array {
		return array_merge( parent::get_meta_fields(), array(
			'image',
			'media',
		) );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_query_args( array $params = array() ): array {
		$params = parent::get_query_args( $params );
		$params['taxonomy'] = "{$this->namespace}_token_category";
		return $params;
	}
}
