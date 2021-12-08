<?php

namespace Tokenly\Wp\Models\Settings;

use Tokenly\Wp\Models\Settings;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;

class TcaSettings extends Settings implements TcaSettingsInterface {
	public $post_types = array();
	public $filter_menu_items = true;
	public $filter_post_results = true;
	protected $option_prefix = 'tca';
	protected $fillable = array(
		'post_types',
		'filter_menu_items',
		'filter_post_results',
	);

	public function is_enabled_for_post_type( string $post_type ) {
		return $this->post_types[ $post_type ] ?? false;
	}
}
