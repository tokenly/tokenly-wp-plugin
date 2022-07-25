<?php

namespace Tokenly\Wp\Presentation\Blocks\Token;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\Token\ItemCardListBlockModelInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;

class ItemCardListBlockModel extends BlockModel
	implements ItemCardListBlockModelInterface
{
	protected string $admin_page_url;
	protected string $namespace;
	protected MetaRepositoryInterface $meta_repository;

	public function __construct(
		string $admin_page_url,
		string $namespace,
		MetaRepositoryInterface $meta_repository
	) {
		$this->admin_page_url = $admin_page_url;
		$this->namespace = $namespace;
		$this->meta_repository = $meta_repository;
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) && !empty( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		$meta_tokens = $this->meta_repository->index();
		$meta_tokens = $meta_tokens->to_array();
		return array(
			'user'       => $user_id,
			'items'      => $meta_tokens,
			'vendor_url' => 
				"{$this->admin_page_url}{$this->namespace}-user-token-balance-index&id={$user_id}",
			'is_admin'   => current_user_can( 'administrator' ),
			'namespace'  => $this->namespace,
		);
	}
}
