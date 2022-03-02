<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\TermRepository;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface;

use Tokenly\Wp\Collections\Token\CategoryTermCollection;
use Tokenly\Wp\Models\Token\CategoryTerm;
use Tokenly\Wp\Interfaces\Collections\Token\CategoryTermCollectionInterface;
use Tokenly\Wp\Interfaces\Models\Token\CategoryTermInterface;

/**
 * Manages Category Terms
 */
class CategoryTermRepository extends TermRepository implements CategoryTermRepositoryInterface {
	protected string $class = CategoryTerm::class;
	protected string $class_collection = CategoryTermCollection::class;

	/**
	 * @inheritDoc
	 */
	protected function get_meta_fields(): array {
		return array_merge( parent::get_meta_fields(), array(
			'image',
			'media',
		) );
	}
}
