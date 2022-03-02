<?php

namespace Tokenly\Wp\Providers;

use Tokenly\Wp\Providers\ServiceProvider;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;

use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\InventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\UserInfoShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Credit\BalanceShortcodeInterface as CreditBalanceShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Credit\InventoryShortcodeInterface as CreditInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\BalanceShortcodeInterface as TokenBalanceShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\InventoryShortcodeInterface as TokenInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaShortcodeInterface as TokenMetaShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaInfoShortcodeInterface as TokenMetaInfoShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaAttributesShortcodeInterface as TokenMetaAttributesShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaMediaShortcodeInterface as TokenMetaMediaShortcodeInterface;
use Twig\Environment;

/**
 * Registers shortcodes
 */
class ShortcodeServiceProvider extends ServiceProvider implements ShortcodeServiceProviderInterface {
	protected string $namespace;
	protected Environment $twig;

	public function __construct(
		string $namespace,
		LoginButtonShortcodeInterface $login_button_shortcode,
		LogoutButtonShortcodeInterface $logout_button_shortcode,
		UserInfoShortcodeInterface $user_info_shortcode,
		InventoryShortcodeInterface $inventory_shortcode,
		CreditBalanceShortcodeInterface $credit_balance_shortcode,
		CreditInventoryShortcodeInterface $credit_inventory_shortcode,
		TokenBalanceShortcodeInterface $token_balance_shortcode,
		TokenInventoryShortcodeInterface $token_inventory_shortcode,
		TokenMetaShortcodeInterface $token_meta_shortcode,
		TokenMetaInfoShortcodeInterface $token_meta_info_shortcode,
		TokenMetaAttributesShortcodeInterface $token_meta_attributes_shortcode,
		TokenMetaMediaShortcodeInterface $token_meta_media_shortcode,
		Environment $twig
	) {
		$this->twig = $twig;
		$this->namespace = $namespace;
		$this->services = array(
			'login'                 => $login_button_shortcode,
			'logout'                => $logout_button_shortcode,
			'user_info'             => $user_info_shortcode,
			'inventory'             => $inventory_shortcode,
			'credit_balance'        => $credit_balance_shortcode,
			'credit_inventory'      => $credit_inventory_shortcode,
			'token_balance'         => $token_balance_shortcode,
			'token_inventory'       => $token_inventory_shortcode,
			'token_meta'            => $token_meta_shortcode,
			'token_meta_info'       => $token_meta_info_shortcode,
			'token_meta_attributes' => $token_meta_attributes_shortcode,
			'token_meta_media'      => $token_meta_media_shortcode,
		);
	}

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		foreach ( $this->services as $key => $service ) {
			$name = "{$this->namespace}_{$key}";
			add_shortcode( $name, function(  $atts = array(), $content = null, $tag = ''  ) use ( $service ) {
				if ( !is_array( $atts ) ) {
					$atts = array();
				}
				$response = $service->shortcode_callback( $atts, $content, $tag );
				return $this->render_shortcode( $response );
			} );
			$service->register();
		}
	}

	/**
	 * Renders the shortcode using the specified parameters
	 * @param array $parameters Shortcode parameters
	 * @return string
	 */
	protected function render_shortcode( array $parameters = array() ): string {
		$template = $parameters['template'];
		$data = array();
		if ( isset( $parameters['data'] ) && is_array( $parameters['data'] ) ) {
			$data = $parameters['data'];
		}
		$html = $this->twig->render( $template, $data );
		return $html;
	}
}
