<?php

use Psr\Container\ContainerInterface;
use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Tokenly\Wp\Services\AuthService;
use Tokenly\Wp\Services\LifecycleService;
use Tokenly\Wp\Services\ResourceService;
use Tokenly\Wp\Services\QueryService;
use Tokenly\Wp\Services\Domain\AddressService;
use Tokenly\Wp\Services\Domain\BalanceService;
use Tokenly\Wp\Services\Domain\CreditAccountService;
use Tokenly\Wp\Services\Domain\CreditGroupService;
use Tokenly\Wp\Services\Domain\CreditTransactionService;
use Tokenly\Wp\Services\Domain\OauthUserService;
use Tokenly\Wp\Services\Domain\PostService;
use Tokenly\Wp\Services\Domain\PromiseMetaService;
use Tokenly\Wp\Services\Domain\PromiseService;
use Tokenly\Wp\Services\Domain\SourceService;
use Tokenly\Wp\Services\Domain\TokenMetaService;
use Tokenly\Wp\Services\Domain\UserService;
use Tokenly\Wp\Repositories\AddressRepository;
use Tokenly\Wp\Repositories\BalanceRepository;
use Tokenly\Wp\Repositories\CreditAccountRepository;
use Tokenly\Wp\Repositories\CreditGroupRepository;
use Tokenly\Wp\Repositories\CreditTransactionRepository;
use Tokenly\Wp\Repositories\OauthUserRepository;
use Tokenly\Wp\Repositories\PromiseRepository;
use Tokenly\Wp\Repositories\SourceRepository;
use Tokenly\Wp\Repositories\UserRepository;
use Tokenly\Wp\Repositories\Post\PostRepository;
use Tokenly\Wp\Repositories\Post\PromiseMetaRepository;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;
use Tokenly\Wp\Repositories\General\MetaRepository;
use Tokenly\Wp\Repositories\General\OptionRepository;
use Tokenly\Wp\Repositories\General\UserMetaRepository;
use Tokenly\Wp\Routes\AdminRouter;
use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\Wp\Routes\PostTypeRouter;
use Tokenly\Wp\Routes\WebRouter;
use Tokenly\Wp\Controllers\Web\AuthController;
use Tokenly\Wp\Controllers\Web\PostController;
use Tokenly\Wp\Controllers\Web\TokenMetaController;
use Tokenly\Wp\Controllers\Web\UserController;
use Tokenly\Wp\Controllers\Web\Admin\BalancesController;
use Tokenly\Wp\Controllers\Web\Admin\ConnectionController;
use Tokenly\Wp\Controllers\Web\Admin\CreditGroupController;
use Tokenly\Wp\Controllers\Web\Admin\CreditTransactionController;
use Tokenly\Wp\Controllers\Web\Admin\DashboardController;
use Tokenly\Wp\Controllers\Web\Admin\PromiseController;
use Tokenly\Wp\Controllers\Web\Admin\SettingsController;
use Tokenly\Wp\Controllers\Web\Admin\SourceController;
use Tokenly\Wp\Controllers\Web\Admin\VendorController;
use Tokenly\Wp\Controllers\Web\Admin\WhitelistController;
use Tokenly\Wp\Controllers\Api\AuthController as AuthApiController;
use Tokenly\Wp\Controllers\Api\CreditGroupController as CreditGroupApiController;
use Tokenly\Wp\Controllers\Api\CreditTransactionController as CreditTransactionApiController;
use Tokenly\Wp\Controllers\Api\PromiseController as PromiseApiController;
use Tokenly\Wp\Controllers\Api\SourceController as SourceApiController;
use Tokenly\Wp\Controllers\Api\UserController as UserApiController;
use Tokenly\Wp\Controllers\Api\WhitelistController as WhitelistApiController;
use Tokenly\Wp\Controllers\Api\Settings\OauthSettingsController as OauthSettingsApiController;
use Tokenly\Wp\Controllers\Api\Settings\IntegrationSettingsController as IntegrationSettingsApiController;
use Tokenly\Wp\Controllers\Api\Settings\TcaSettingsController as TcaSettingsApiController;
use Tokenly\Wp\Controllers\Api\Settings\WhitelistSettingsController as WhitelistSettingsApiController;
use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Collections\AddressCollection;
use Tokenly\Wp\Collections\BalanceCollection;
use Tokenly\Wp\Collections\CreditAccountCollection;
use Tokenly\Wp\Collections\CreditGroupCollection;
use Tokenly\Wp\Collections\CreditTransactionCollection;
use Tokenly\Wp\Collections\PromiseCollection;
use Tokenly\Wp\Collections\PromiseMetaCollection;
use Tokenly\Wp\Collections\PostCollection;
use Tokenly\Wp\Collections\SourceCollection;
use Tokenly\Wp\Collections\TokenMetaCollection;
use Tokenly\Wp\Collections\TcaRuleCollection;
use Tokenly\Wp\Collections\UserCollection;
use Tokenly\Wp\Collections\WhitelistItemCollection;
use Tokenly\Wp\Models\Address;
use Tokenly\Wp\Models\Balance;
use Tokenly\Wp\Models\CreditAccount;
use Tokenly\Wp\Models\CreditGroup;
use Tokenly\Wp\Models\CreditTransaction;
use Tokenly\Wp\Models\OauthUser;
use Tokenly\Wp\Models\Promise;
use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Models\PromiseMeta;
use Tokenly\Wp\Models\Quantity;
use Tokenly\Wp\Models\Integration;
use Tokenly\Wp\Models\Source;
use Tokenly\Wp\Models\TokenMeta;
use Tokenly\Wp\Models\TcaRule;
use Tokenly\Wp\Models\User;
use Tokenly\Wp\Models\GuestUser;
use Tokenly\Wp\Models\WhitelistItem;
use Tokenly\Wp\Models\Settings\OauthSettings;
use Tokenly\Wp\Models\Settings\IntegrationSettings;
use Tokenly\Wp\Models\Settings\TcaSettings;
use Tokenly\Wp\Models\Settings\WhitelistSettings;
use Tokenly\Wp\Presentation\Blocks\AppCreditItemCardListBlockModel;
use Tokenly\Wp\Presentation\Blocks\TokenItemCardListBlockModel;
use Tokenly\Wp\Presentation\Blocks\UserInfoBlockModel;
use Tokenly\Wp\Presentation\Components\AppCreditItemCardComponentModel;
use Tokenly\Wp\Presentation\Components\LoginButtonComponentModel;
use Tokenly\Wp\Presentation\Components\LogoutButtonComponentModel;
use Tokenly\Wp\Presentation\Components\TokenItemCardComponentModel;
use Tokenly\Wp\Presentation\Views\Admin\BalancesShowViewModel;
use Tokenly\Wp\Presentation\Views\Admin\ConnectionViewModel;
use Tokenly\Wp\Presentation\Views\Admin\CreditGroupEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\CreditGroupIndexViewModel;
use Tokenly\Wp\Presentation\Views\Admin\CreditGroupShowViewModel;
use Tokenly\Wp\Presentation\Views\Admin\CreditTransactionIndexViewModel;
use Tokenly\Wp\Presentation\Views\Admin\CreditTransactionStoreViewModel;
use Tokenly\Wp\Presentation\Views\Admin\DashboardViewModel;
use Tokenly\Wp\Presentation\Views\Admin\PostEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\PromiseEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\PromiseShowViewModel;
use Tokenly\Wp\Presentation\Views\Admin\PromiseStoreViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SettingsViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SourceEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SourceIndexViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SourceShowViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SourceStoreViewModel;
use Tokenly\Wp\Presentation\Views\Admin\TokenMetaEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\VendorViewModel;
use Tokenly\Wp\Presentation\Views\Admin\WhitelistViewModel;
use Tokenly\Wp\Presentation\Views\Web\PostAccessDeniedViewModel;
use Tokenly\Wp\Presentation\Views\Web\UserViewModel;
use Tokenly\Wp\Shortcodes\LoginButtonShortcode;
use Tokenly\Wp\Shortcodes\LogoutButtonShortcode;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditAccountServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditAccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditGroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\CreditTransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;;
use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\BalancesControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditGroupControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\CreditTransactionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface as AuthApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\CreditGroupControllerInterface as CreditGroupApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\CreditTransactionControllerInterface as CreditTransactionApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\PromiseControllerInterface as PromiseApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SourceControllerInterface as SourceApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface as UserApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\OauthSettingsControllerInterface as OauthSettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\IntegrationSettingsControllerInterface as IntegrationSettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\TcaSettingsControllerInterface as TcaSettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Settings\WhitelistSettingsControllerInterface as WhitelistSettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditAccountFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditAccountHistoryFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditGroupFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditGroupHistoryFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\CreditTransactionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\QuantityFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\SourceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaRuleFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditAccountCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditGroupCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\CreditTransactionCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PostCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\WhitelistItemCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\CreditGroupCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\CreditTransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\WhitelistItemCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\CreditAccountInterface;
use Tokenly\Wp\Interfaces\Models\CreditAccountHistoryInterface;
use Tokenly\Wp\Interfaces\Models\CreditGroupInterface;
use Tokenly\Wp\Interfaces\Models\CreditGroupHistoryInterface;
use Tokenly\Wp\Interfaces\Models\CreditTransactionInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Models\TcaRuleInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\QuantityInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;
use Tokenly\Wp\Interfaces\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\AppCreditItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\TokenItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\AppCreditItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\TokenItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\BalancesShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\ConnectionViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditGroupShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditTransactionIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\CreditTransactionStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PostEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PromiseStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SettingsViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceIndexViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceShowViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SourceStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TokenMetaEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\VendorViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\WhitelistViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\UserViewModelInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

return array(
	//Variables
	'general.name'             => 'tokenly-wp-plugin',
	'general.namespace'        => 'tokenly',
	'general.root_dir'         => \DI\factory( function( string $name ) {
		return WP_PLUGIN_DIR . '/' . $name;
	} )->parameter( 'name', \DI\get( 'general.name' ) ),
	'general.root_url'         => \DI\factory( function( string $name ) {
		return WP_PLUGIN_URL . '/' . $name;
	} )->parameter( 'name', \DI\get( 'general.name' ) ),
	'general.root_filepath'    => \DI\factory( function( string $root_dir ) {
		return $root_dir . '/tokenly-wp-plugin.php';
	} )->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'general.root_filepath'    => \DI\factory( function( string $root_dir ) {
		return $root_dir . '/tokenly-wp-plugin.php';
	} )->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'api.host'                 => 'https://tokenpass.tokenly.com',
	'twig.template_dir'        => \DI\factory( function( string $root_dir ) {
		return $root_dir . '/resources/views/';
	} )->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'twig.template_cache_dir'  => \DI\factory( function( string $root_dir ) {
		return $root_dir . '/build/template-cache/';
	} )->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'oauth.callback_route'     => \DI\factory( function( string $namespace ) {
		$site_url = get_site_url();
		return "{$site_url}/{$namespace}/oauth/callback";
	} )->parameter( 'namespace', \DI\get( 'general.namespace' ) ),
	'oauth.host'               => \DI\factory( function( string $api_host ) {
		return $api_host . '/oauth/authorize';
	} )->parameter( 'api_host', \DI\get( 'api.host' ) ),
	//Providers
	AppServiceProviderInterface::class             => \DI\autowire( AppServiceProvider::class ),
	RouteServiceProviderInterface::class           => \DI\autowire( RouteServiceProvider::class ),
	ShortcodeServiceProviderInterface::class       => \DI\autowire( ShortcodeServiceProvider::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Controllers - API
	AuthApiControllerInterface::class                 => \DI\autowire( AuthApiController::class ),
	CreditGroupApiControllerInterface::class          => \DI\autowire( CreditGroupApiController::class ),
	CreditTransactionApiControllerInterface::class    => \DI\autowire( CreditTransactionApiController::class ),
	PromiseApiControllerInterface::class              => \DI\autowire( PromiseApiController::class ),
	SourceApiControllerInterface::class               => \DI\autowire( SourceApiController::class ),
	UserApiControllerInterface::class                 => \DI\autowire( UserApiController::class ),
	//Controllers - API - Settings
	IntegrationSettingsApiControllerInterface::class  => \DI\autowire( IntegrationSettingsApiController::class ),
	OauthSettingsApiControllerInterface::class        => \DI\autowire( OauthSettingsApiController::class ),
	TcaSettingsApiControllerInterface::class          => \DI\autowire( TcaSettingsApiController::class ),
	WhitelistSettingsApiControllerInterface::class    => \DI\autowire( WhitelistSettingsApiController::class ),
	//Controllers - Admin
	BalancesControllerInterface::class             => \DI\autowire( BalancesController::class ),
	CreditGroupControllerInterface::class          => \DI\autowire( CreditGroupController::class ),
	CreditTransactionControllerInterface::class    => \DI\autowire( CreditTransactionController::class ),
	ConnectionControllerInterface::class           => \DI\autowire( ConnectionController::class ),
	DashboardControllerInterface::class            => \DI\autowire( DashboardController::class ),
	PromiseControllerInterface::class              => \DI\autowire( PromiseController::class ),
	SettingsControllerInterface::class             => \DI\autowire( SettingsController::class ),
	SourceControllerInterface::class               => \DI\autowire( SourceController::class ),
	VendorControllerInterface::class               => \DI\autowire( VendorController::class ),
	WhitelistControllerInterface::class            => \DI\autowire( WhitelistController::class ),
	//Controllers - Web
	AuthControllerInterface::class                 => \DI\autowire( AuthController::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	PostControllerInterface::class                 => \DI\autowire( PostController::class ),
	TokenMetaControllerInterface::class            => \DI\autowire( TokenMetaController::class ),
	UserControllerInterface::class                 => \DI\autowire( UserController::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Shortcodes
	LoginButtonShortcodeInterface::class              => \DI\autowire( LoginButtonShortcode::class ),
	LogoutButtonShortcodeInterface::class             => \DI\autowire( LogoutButtonShortcode::class ),
	//Services - Application
	AuthServiceInterface::class                    => \DI\autowire( AuthService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'oauth_callback_route', \DI\get('oauth.callback_route') )
		->constructorParameter( 'api_host', \DI\get( 'api.host' ) ),
	LifecycleServiceInterface::class               => \DI\autowire( LifecycleService::class )
		->constructorParameter( 'root_filepath', \DI\get( 'general.root_filepath' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	ResourceServiceInterface::class                => \DI\autowire( ResourceService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) )
		->constructorParameter( 'root_url', \DI\get( 'general.root_url' ) ),
	QueryServiceInterface::class                   => \DI\autowire( QueryService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Services - Domain
	AddressServiceInterface::class                 => \DI\autowire( AddressService::class ),
	BalanceServiceInterface::class                 => \DI\autowire( BalanceService::class ),
	CreditAccountServiceInterface::class           => \DI\autowire( CreditAccountService::class ),
	CreditGroupServiceInterface::class             => \DI\autowire( CreditGroupService::class ),
	CreditTransactionServiceInterface::class       => \DI\autowire( CreditTransactionService::class ),
	OauthUserServiceInterface::class               => \DI\autowire( OauthUserService::class ),
	PostServiceInterface::class                    => \DI\autowire( PostService::class ),
	PromiseMetaServiceInterface::class             => \DI\autowire( PromiseMetaService::class ),
	PromiseServiceInterface::class                 => \DI\autowire( PromiseService::class ),
	SourceServiceInterface::class                  => \DI\autowire( SourceService::class ),
	TokenMetaServiceInterface::class               => \DI\autowire( TokenMetaService::class ),
	UserServiceInterface::class                    => \DI\autowire( UserService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	WhitelistServiceInterface::class               => \DI\autowire( WhitelistService::class ),
	//Repositories - General
	MetaRepositoryInterface::class                 => \DI\autowire( MetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	UserMetaRepositoryInterface::class             => \DI\autowire( UserMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	OptionRepositoryInterface::class               => \DI\autowire( OptionRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Repositories - Domain
	AddressRepositoryInterface::class              => \DI\autowire( AddressRepository::class ),
	BalanceRepositoryInterface::class              => \DI\autowire( BalanceRepository::class ),
	CreditAccountRepositoryInterface::class        => \DI\autowire( CreditAccountRepository::class ),
	CreditGroupRepositoryInterface::class          => \DI\autowire( CreditGroupRepository::class ),
	CreditTransactionRepositoryInterface::class    => \DI\autowire( CreditTransactionRepository::class ),
	OauthUserRepositoryInterface::class            => \DI\autowire( OauthUserRepository::class ),
	PostRepositoryInterface::class                 => \DI\autowire( PostRepository::class ),
	PromiseRepositoryInterface::class              => \DI\autowire( PromiseRepository::class ),
	PromiseMetaRepositoryInterface::class          => \DI\autowire( PromiseMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	SourceRepositoryInterface::class               => \DI\autowire( SourceRepository::class ),
	TokenMetaRepositoryInterface::class            => \DI\autowire( TokenMetaRepository::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	UserRepositoryInterface::class                 => \DI\autowire( UserRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Routes
	AdminRouterInterface::class                    => \DI\autowire( AdminRouter::class )
		->constructorParameter( 'root_dir', DI\get( 'general.root_dir' ) )
		->constructorParameter( 'api_host', DI\get( 'api.host' ) )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	ApiRouterInterface::class                      => \DI\autowire( ApiRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	PostTypeRouterInterface::class                 => \DI\autowire( PostTypeRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	WebRouterInterface::class                      => \DI\autowire( WebRouter::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Presentation - Block models
	AppCreditItemCardListBlockModelInterface::class  => \DI\autowire( AppCreditItemCardListBlockModel::class ),
	TokenItemCardListBlockModelInterface::class      => \DI\autowire( TokenItemCardListBlockModel::class ),
	UserInfoBlockModelInterface::class               => \DI\autowire( UserInfoBlockModel::class ),
	//Presentation - Component models
	AppCreditItemCardComponentModelInterface::class  => \DI\autowire( AppCreditItemCardComponentModel::class ),
	LoginButtonComponentModelInterface::class        => \DI\autowire( LoginButtonComponentModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	LogoutButtonComponentModelInterface::class       => \DI\autowire( LogoutButtonComponentModel::class )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	TokenItemCardComponentModelInterface::class      => \DI\autowire( TokenItemCardComponentModel::class ),
	//Presentation - View models - Admin
	BalancesShowViewModelInterface::class            => \DI\autowire( BalancesShowViewModel::class ),
	ConnectionViewModelInterface::class              => \DI\autowire( ConnectionViewModel::class ),
	CreditGroupEditViewModelInterface::class         => \DI\autowire( CreditGroupEditViewModel::class ),
	CreditGroupIndexViewModelInterface::class        => \DI\autowire( CreditGroupIndexViewModel::class ),
	CreditGroupShowViewModelInterface::class         => \DI\autowire( CreditGroupShowViewModel::class ),
	CreditTransactionIndexViewModelInterface::class  => \DI\autowire( CreditTransactionIndexViewModel::class ),
	CreditTransactionStoreViewModelInterface::class  => \DI\autowire( CreditTransactionStoreViewModel::class ),
	DashboardViewModelInterface::class               => \DI\autowire( DashboardViewModel::class ),
	PostEditViewModelInterface::class                => \DI\autowire( PostEditViewModel::class ),
	PromiseEditViewModelInterface::class             => \DI\autowire( PromiseEditViewModel::class ),
	PromiseShowViewModelInterface::class             => \DI\autowire( PromiseShowViewModel::class ),
	PromiseStoreViewModelInterface::class            => \DI\autowire( PromiseStoreViewModel::class ),
	SettingsViewModelInterface::class                => \DI\autowire( SettingsViewModel::class )
		->constructorParameter( 'oauth_callback_route', \DI\get( 'oauth.callback_route' ) ),
	SourceEditViewModelInterface::class              => \DI\autowire( SourceEditViewModel::class ),
	SourceIndexViewModelInterface::class             => \DI\autowire( SourceIndexViewModel::class ),
	SourceShowViewModelInterface::class              => \DI\autowire( SourceShowViewModel::class ),
	SourceStoreViewModelInterface::class             => \DI\autowire( SourceStoreViewModel::class ),
	TokenMetaEditViewModelInterface::class           => \DI\autowire( TokenMetaEditViewModel::class ),
	VendorViewModelInterface::class                  => \DI\autowire( VendorViewModel::class ),
	WhitelistViewModelInterface::class               => \DI\autowire( WhitelistViewModel::class ),
	//Presentation - View models - Web
	PostAccessDeniedViewModelInterface::class        => \DI\autowire( PostAccessDeniedViewModel::class ),
	UserViewModelInterface::class                    => \DI\autowire( UserViewModel::class ),
	//Collections
	CollectionInterface::class                   => \DI\autowire( Collection::class ),
	AddressCollectionInterface::class            => \DI\autowire( AddressCollection::class ),
	BalanceCollectionInterface::class            => \DI\autowire( BalanceCollection::class ),
	CreditAccountCollectionInterface::class      => \DI\autowire( CreditAccountCollection::class ),
	CreditGroupCollectionInterface::class        => \DI\autowire( CreditGroupCollection::class ),
	CreditTransactionCollectionInterface::class  => \DI\autowire( CreditTransactionCollection::class ),
	PromiseCollectionInterface::class            => \DI\autowire( PromiseCollection::class ),
	PromiseMetaCollectionInterface::class        => \DI\autowire( PromiseMetaCollection::class ),
	PostCollectionInterface::class               => \DI\autowire( PostCollection::class ),
	SourceCollectionInterface::class             => \DI\autowire( SourceCollection::class ),
	TokenMetaCollectionInterface::class          => \DI\autowire( TokenMetaCollection::class ),
	TcaRuleCollectionInterface::class            => \DI\autowire( TcaRuleCollection::class ),
	UserCollectionInterface::class               => \DI\autowire( UserCollection::class ),
	WhitelistItemCollectionInterface::class      => \DI\autowire( WhitelistItemCollection::class ),
	//Models

	CurrentUserInterface::class                  => \DI\factory( function (
		ContainerInterface $container,
		UserServiceInterface $user_service
	) {
		$user = null;
		$user_id = get_current_user_id();
		if ( $user_id != 0 ) {
			$user = $user_service->show( array(
				'id' => $user_id,
			) );
		}
		if ( !$user || $user_id == 0 ) {
			$user = $container->make( GuestUserInterface::class );
		}
		return $user;
	} ),
	AddressInterface::class                => \DI\autowire( Address::class ),
	BalanceInterface::class                => \DI\autowire( Balance::class ),
	CreditAccountInterface::class          => \DI\autowire( CreditAccount::class ),
	CreditAccountHistoryInterface::class   => \DI\autowire( CreditAccountHistory::class ),
	CreditGroupInterface::class            => \DI\autowire( CreditGroup::class ),
	CreditGroupHistoryInterface::class     => \DI\autowire( CreditGroupHistory::class ),
	CreditTransactionInterface::class      => \DI\autowire( CreditTransaction::class ),
	OauthUserInterface::class              => \DI\autowire( OauthUser::class ),
	PostInterface::class                   => \DI\autowire( Post::class ),
	PromiseInterface::class                => \DI\autowire( Promise::class ),
	PromiseMetaInterface::class            => \DI\autowire( PromiseMeta::class ), 
	SourceInterface::class                 => \DI\autowire( Source::class ), 
	TokenMetaInterface::class              => \DI\autowire( TokenMeta::class ), 
	TcaRuleInterface::class                => \DI\autowire( TcaRule::class ), 
	UserInterface::class                   => \DI\autowire( User::class ),
	WhitelistItemInterface::class          => \DI\autowire( WhitelistItem::class ),
	QuantityInterface::class               => \DI\autowire( Quantity::class ),
	GuestUserInterface::class              => \DI\autowire( GuestUser::class ),
	IntegrationInterface::class            => \DI\autowire( Integration::class ),
	//Models - Settings
	OauthSettingsInterface::class          => \DI\autowire( OauthSettings::class ),
	IntegrationSettingsInterface::class    => \DI\autowire( IntegrationSettings::class ),
	TcaSettingsInterface::class            => \DI\autowire( TcaSettings::class ),
	WhitelistSettingsInterface::class      => \DI\autowire( WhitelistSettings::class ),
	//Factories
	AddressFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, AddressInterface::class ) extends ConcreteFactory implements AddressFactoryInterface {};
	} ),
	BalanceFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, BalanceInterface::class ) extends ConcreteFactory implements BalanceFactoryInterface {};
	} ),
	CreditAccountFactoryInterface::class            => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, CreditAccountInterface::class ) extends ConcreteFactory implements CreditAccountFactoryInterface {};
	} ),
	CreditAccountHistoryFactoryInterface::class     => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, CreditAccountHistoryInterface::class ) extends ConcreteFactory implements CreditAccountHistoryFactoryInterface {};
	} ),
	CreditGroupFactoryInterface::class              => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, CreditGroupInterface::class ) extends ConcreteFactory implements CreditGroupFactoryInterface {};
	} ),
	CreditGroupHistoryFactoryInterface::class       => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, CreditGroupHistoryInterface::class ) extends ConcreteFactory implements CreditGroupHistoryFactoryInterface {};
	} ),
	CreditTransactionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, CreditTransactionInterface::class ) extends ConcreteFactory implements CreditTransactionFactoryInterface {};
	} ),
	OauthUserFactoryInterface::class                => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, OauthUserInterface::class ) extends ConcreteFactory implements OauthUserFactoryInterface {};
	} ),
	PostFactoryInterface::class                     => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, PostInterface::class ) extends ConcreteFactory implements PostFactoryInterface {};
	} ),
	PromiseFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, PromiseInterface::class ) extends ConcreteFactory implements PromiseFactoryInterface {};
	} ),
	PromiseMetaFactoryInterface::class              => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, PromiseMetaInterface::class ) extends ConcreteFactory implements PromiseMetaFactoryInterface {};
	} ),
	QuantityFactoryInterface::class                 => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, QuantityInterface::class ) extends ConcreteFactory implements QuantityFactoryInterface {};
	} ),
	SourceFactoryInterface::class                   => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, SourceInterface::class ) extends ConcreteFactory implements SourceFactoryInterface {};
	} ),
	TokenMetaFactoryInterface::class                => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenMetaInterface::class ) extends ConcreteFactory implements TokenMetaFactoryInterface {};
	} ),
	TcaRuleFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TcaRuleInterface::class ) extends ConcreteFactory implements TcaRuleFactoryInterface {};
	} ),
	UserFactoryInterface::class                     => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, UserInterface::class ) extends ConcreteFactory implements UserFactoryInterface {};
	} ),
	WhitelistItemFactoryInterface::class            => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, WhitelistItemInterface::class ) extends ConcreteFactory implements WhitelistItemFactoryInterface {};
	} ),
	//Factories - collections
	AddressCollectionFactoryInterface::class              => \DI\factory( function( ContainerInterface $container, AddressFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, AddressCollectionInterface::class ) extends ConcreteCollectionFactory implements AddressCollectionFactoryInterface {};
	} ),
	BalanceCollectionFactoryInterface::class              => \DI\factory( function( ContainerInterface $container, BalanceFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, BalanceCollectionInterface::class ) extends ConcreteCollectionFactory implements BalanceCollectionFactoryInterface {};
	} ),
	CreditAccountCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, CreditAccountFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, CreditAccountCollectionInterface::class ) extends ConcreteCollectionFactory implements CreditAccountCollectionFactoryInterface {};
	} ),
	CreditGroupCollectionFactoryInterface::class          => \DI\factory( function( ContainerInterface $container, CreditGroupFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, CreditGroupCollectionInterface::class ) extends ConcreteCollectionFactory implements CreditGroupCollectionFactoryInterface {};
	} ),
	CreditTransactionCollectionFactoryInterface::class    => \DI\factory( function( ContainerInterface $container, CreditTransactionFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, CreditTransactionCollectionInterface::class ) extends ConcreteCollectionFactory implements CreditTransactionCollectionFactoryInterface {};
	} ),
	PromiseCollectionFactoryInterface::class              => \DI\factory( function( ContainerInterface $container, PromiseFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PromiseCollectionInterface::class ) extends ConcreteCollectionFactory implements PromiseCollectionFactoryInterface {};
	} ),
	PostCollectionFactoryInterface::class                 => \DI\factory( function( ContainerInterface $container, PostFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PostCollectionInterface::class ) extends ConcreteCollectionFactory implements PostCollectionFactoryInterface {};
	} ),
	PromiseMetaCollectionFactoryInterface::class          => \DI\factory( function( ContainerInterface $container, PromiseMetaFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PromiseMetaCollectionInterface::class ) extends ConcreteCollectionFactory implements PromiseMetaCollectionFactoryInterface {};
	} ),
	SourceCollectionFactoryInterface::class               => \DI\factory( function( ContainerInterface $container, SourceFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, SourceCollectionInterface::class ) extends ConcreteCollectionFactory implements SourceCollectionFactoryInterface {};
	} ),
	TokenMetaCollectionFactoryInterface::class            => \DI\factory( function( ContainerInterface $container, TokenMetaFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenMetaCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenMetaCollectionFactoryInterface {};
	} ),
	TcaRuleCollectionFactoryInterface::class              => \DI\factory( function( ContainerInterface $container, TcaRuleFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TcaRuleCollectionInterface::class ) extends ConcreteCollectionFactory implements TcaRuleCollectionFactoryInterface {};
	} ),
	UserCollectionFactoryInterface::class                 => \DI\factory( function( ContainerInterface $container, UserFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, UserCollectionInterface::class ) extends ConcreteCollectionFactory implements UserCollectionFactoryInterface {};
	} ),
	WhitelistItemCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, WhitelistItemFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, WhitelistItemCollectionInterface::class ) extends ConcreteCollectionFactory implements WhitelistItemCollectionFactoryInterface {};
	} ),
	//Third-party
	TokenpassAPI::class => \DI\factory( function ( 
		ContainerInterface $container,
		OptionRepositoryInterface $option_repository,
		string $api_host,
		string $oauth_callback_route
	) {
		$settings = $option_repository->index( array(
			'integration_client_id',
			'integration_client_secret',
		) );
		$client_id = $settings['integration_client_id'] ?? null;
		$client_secret = $settings['integration_client_secret'] ?? null;
		$privileged_client_id = $client_id;
		$privileged_client_secret = $client_secret;
		$oauth_client_id = $client_id;
		$oauth_client_secret = $client_secret;
		$tokenpass_url = $api_host;
		$redirect_uri = $oauth_callback_route;
		return new TokenpassAPI( 
			$client_id,
			$client_secret,
			$privileged_client_id,
			$privileged_client_secret,
			$tokenpass_url,
			$redirect_uri,
			$oauth_client_id,
			$oauth_client_secret
		);
	} )
		->parameter( 'api_host', \DI\get( 'api.host' ) )
		->parameter( 'oauth_callback_route', \DI\get( 'oauth.callback_route' ) )
	,
	TokenpassAPIInterface::class => \DI\get( TokenpassAPI::class ),
	Environment::class => \DI\factory( function (
		string $twig_template_dir,
		string $twig_template_cache_dir
	) {
		$loader = new FilesystemLoader( $twig_template_dir );
		$twig = new Environment( $loader, array(
			// 'cache' => $twig_template_cache_dir
			'cache' => false,
		) );
		$twig->registerUndefinedFunctionCallback(function( $name ) {
			if ( function_exists( $name ) ) {
				return new \Twig\TwigFunction( $name, function() use ( $name ) {
					return call_user_func_array( $name, func_get_args() );
				} );
			}
			throw new \RuntimeException( sprintf( 'Function %s not found', $name ) );
		});
		return $twig;
	} )
		->parameter( 'twig_template_dir', \DI\get( 'twig.template_dir' ) )
		->parameter( 'twig_template_cache_dir', \DI\get( 'twig.template_cache_dir' ) ),
);

class ConcreteFactory {
	protected $container;
	public $class;

	public function __construct( ContainerInterface $container, $class ) {
		$this->container = $container;
		$this->class = $class;
	}

	public function create( $data ) {
		if ( is_a( $data, $this->class ) ) {
			return $data;
		}
		return $this->container->make( $this->class, array(
			'data' => $data,
		) );
	}
}

class ConcreteCollectionFactory {
	protected $container;
	protected $item_factory;
	public $class;

	public function __construct(
		ContainerInterface $container,
		$item_factory,
		string $class
	) {
		$this->container = $container;
		$this->item_factory = $item_factory;
		$this->class = $class;
	}

	public function create( array $data, $args = array() ) {
		foreach ( $data as &$item ) {
			$item = $this->item_factory->create( $item );
		};
		$collection = $this->container->make( $this->class, array(
			'items' => $data,
		) );
		return $collection;
	}
}
