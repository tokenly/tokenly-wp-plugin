<?php

namespace Tokenly\Wp\Repositories\Credit;

use Tokenly\Wp\Repositories\SettingsRepository;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupWhitelistRepositoryInterface;

use Tokenly\Wp\Models\Credit\GroupWhitelist;

class GroupWhitelistRepository extends SettingsRepository
	implements GroupWhitelistRepositoryInterface
{
	protected string $option_prefix = 'credit_group_whitelist';
	protected array $meta_keys = array(
		'items',
	);
	protected string $class = GroupWhitelist::class;
}
