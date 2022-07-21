<?php

/**
 * Collection of Promise meta objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\PostCollection;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseMetaCollectionInterface;

use Tokenly\Wp\Models\Token\PromiseMeta;

class PromiseMetaCollection extends PostCollection
	implements PromiseMetaCollectionInterface
{
	protected string $item_type = PromiseMeta::class;

    public function __get( $name ) {
		switch ( $name ) {
			case 'users':
				return $this->get_users();
				break;
		}
    }

	protected function get_users(): array {
		$users = array();
		$items = clone $this;
		$source_users = $items->extract( 'source_user_id' );
		$items = clone $this;
		$destination_users = $items->extract( 'destination_user_id' );
		$users = array_merge( $users, $source_users, $destination_users );
		return $users;
	}
}
