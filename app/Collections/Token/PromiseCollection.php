<?php

/**
 * Collection of Promise objects
 */

namespace Tokenly\Wp\Collections\Token;

use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface;

use Tokenly\Wp\Models\Token\Promise;
use Tokenly\Wp\Collections\Token\PromiseMetaCollection;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;

class PromiseCollection extends Collection implements PromiseCollectionInterface {
	protected string $item_type = Promise::class;

	public function get_users(): array {
		$items = clone $this;
		$items = $items->extract( 'promise_meta' );
		$items = new PromiseMetaCollection( $items );
		$users = $items->get_users();
		return $users;
	}

	public function embed_users( UserCollectionInterface $users ) {
		$users = clone $users;
		$users = $users->key_by_field( 'uuid' );
		$users = $users->to_array();
		$promises = $this->to_array();
		$promises = array_map( function( $promise ) use ( $users ) {
			if ( !isset( $promise['promise_meta'] ) ) {
				return $promise;
			}
			$meta = $promise['promise_meta'];
			$destination = $meta['destination_user_id'];
			$source = $meta['source_user_id'];
			$meta['destination_user'] = $users[$destination] ?? null;
			$meta['source_user'] = $users[$source] ?? null;
			$promise['promise_meta'] = $meta;
			return $promise;
		}, $promises );
		return $promises;
	}
}
