<?php

namespace Tokenly\Wp\Repositories\Token;

use Tokenly\Wp\Repositories\SettingsRepository;
use Tokenly\Wp\Interfaces\Repositories\Token\WhitelistRepositoryInterface;

use Tokenly\Wp\Models\Token\Whitelist;

class WhitelistRepository extends SettingsRepository implements WhitelistRepositoryInterface {
	protected string $option_prefix = 'token_whitelist';
	protected array $meta_keys = array(
		'enabled',
		'items',
	);
	protected string $class = Whitelist::class;
}
