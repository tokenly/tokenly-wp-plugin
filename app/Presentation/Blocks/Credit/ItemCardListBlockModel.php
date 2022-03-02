<?php

namespace Tokenly\Wp\Presentation\Blocks\Credit;

use Tokenly\Wp\Presentation\Blocks\BlockModel;
use Tokenly\Wp\Interfaces\Presentation\Blocks\Credit\ItemCardListBlockModelInterface;

class ItemCardListBlockModel extends BlockModel implements ItemCardListBlockModelInterface {
	protected string $admin_page_url;
	protected string $namespace;

	public function __construct(
		string $admin_page_url,
		string $namespace
	) {
		$this->admin_page_url = $admin_page_url;
		$this->namespace = $namespace;
	}

	/**
	 * @inheritDoc
	 */
	public function prepare( array $data = array() ): array {
		$user_id = 'me';
		if ( isset( $data['user_id'] ) ) {
			$user_id = $data['user_id'];
		}
		return array(
			'user'       => $user_id,
			'items'      => array(),
			'vendor_url' => "{$this->admin_page_url}{$this->namespace}-user-credit-balance-index&id={$user_id}",
			'is_admin'   => current_user_can( 'administrator' ),
			'namespace'  => $this->namespace,
		);
	}
}
