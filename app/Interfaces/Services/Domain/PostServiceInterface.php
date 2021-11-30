<?php

namespace Tokenly\Wp\Interfaces\Services\Domain;

use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;

interface PostServiceInterface {
	public function show( array $params = array() );
	public function update( int $post_id, $params = array() );
	public function get_tca_rules( int $post_id );
	public function set_tca_rules( int $post_id, TcaRuleCollectionInterface $rules );
	public function can_access_post( int $post_id, UserInterface $user );
}
