<?php

namespace Tokenly\Wp\Presentation\Views\Admin\Token;

use Tokenly\Wp\Presentation\Views\Admin\PostEditViewModel;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\MetaEditViewModelInterface;

use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;

class MetaEditViewModel extends PostEditViewModel implements MetaEditViewModelInterface {
	public function __construct(
		MetaRepositoryInterface $meta_repository,
		TcaSettingsRepositoryInterface $tca_settings_repository
	) {
		parent::__construct( $tca_settings_repository, $meta_repository );
	}
}
