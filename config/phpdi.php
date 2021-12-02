<?php
use Psr\Container\ContainerInterface;
use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Tokenly\Wp\Services\AuthService;
use Tokenly\Wp\Services\LifecycleService;
use Tokenly\Wp\Services\ResourceService;
use Tokenly\Wp\Services\TcaService;
use Tokenly\Wp\Services\QueryService;
use Tokenly\Wp\Services\Domain\AddressService;
use Tokenly\Wp\Services\Domain\BalanceService;
use Tokenly\Wp\Services\Domain\OauthUserService;
use Tokenly\Wp\Services\Domain\PostService;
use Tokenly\Wp\Services\Domain\PromiseMetaService;
use Tokenly\Wp\Services\Domain\PromiseService;
use Tokenly\Wp\Services\Domain\SourceService;
use Tokenly\Wp\Services\Domain\TokenMetaService;
use Tokenly\Wp\Services\Domain\UserService;
use Tokenly\Wp\Repositories\AddressRepository;
use Tokenly\Wp\Repositories\BalanceRepository;
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
use Tokenly\Wp\Components\ButtonLoginComponent;
use Tokenly\Wp\Components\ButtonLogoutComponent;
use Tokenly\Wp\Components\CardTokenItemComponent;
use Tokenly\Wp\Controllers\Web\PostController;
use Tokenly\Wp\Controllers\Web\TokenMetaController;
use Tokenly\Wp\Controllers\Web\UserController;
use Tokenly\Wp\Controllers\Web\Admin\BalancesController;
use Tokenly\Wp\Controllers\Web\Admin\ConnectionController;
use Tokenly\Wp\Controllers\Web\Admin\DashboardController;
use Tokenly\Wp\Controllers\Web\Admin\PromiseController;
use Tokenly\Wp\Controllers\Web\Admin\SettingsController;
use Tokenly\Wp\Controllers\Web\Admin\SourceController;
use Tokenly\Wp\Controllers\Web\Admin\VendorController;
use Tokenly\Wp\Controllers\Web\Admin\WhitelistController;
use Tokenly\Wp\Controllers\Api\AuthController as AuthApiController;
use Tokenly\Wp\Controllers\Api\PromiseController as PromiseApiController;
use Tokenly\Wp\Controllers\Api\IntegrationSettingsController as IntegrationSettingsApiController;
use Tokenly\Wp\Controllers\Api\TcaSettingsController as TcaSettingsApiController;
use Tokenly\Wp\Controllers\Api\SourceController as SourceApiController;
use Tokenly\Wp\Controllers\Api\UserController as UserApiController;
use Tokenly\Wp\Controllers\Api\WhitelistController as WhitelistApiController;
use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Collections\AddressCollection;
use Tokenly\Wp\Collections\BalanceCollection;
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
use Tokenly\Wp\Models\OauthUser;
use Tokenly\Wp\Models\Promise;
use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Models\PromiseMeta;
use Tokenly\Wp\Models\Integration;
use Tokenly\Wp\Models\IntegrationSettings;
use Tokenly\Wp\Models\TcaSettings;
use Tokenly\Wp\Models\Source;
use Tokenly\Wp\Models\TokenMeta;
use Tokenly\Wp\Models\TcaRule;
use Tokenly\Wp\Models\User;
use Tokenly\Wp\Models\GuestUser;
use Tokenly\Wp\Models\Whitelist;
use Tokenly\Wp\Models\WhitelistItem;
use Tokenly\Wp\Shortcodes\LoginButtonShortcode;
use Tokenly\Wp\Shortcodes\LogoutButtonShortcode;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\TcaServiceInterface;
use Tokenly\Wp\Interfaces\Services\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\AddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\SourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
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
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\BalancesControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\PromiseControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SourceControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\VendorControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\WhitelistControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface as AuthApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\PromiseControllerInterface as PromiseApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\IntegrationSettingsControllerInterface as IntegrationSettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\TcaSettingsControllerInterface as TcaSettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SourceControllerInterface as SourceApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface as UserApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\WhitelistControllerInterface as WhitelistApiControllerInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\SourceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TcaRuleFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
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
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Models\TcaRuleInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLoginComponentInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLogoutComponentInterface;
use Tokenly\Wp\Interfaces\Components\CardTokenItemComponentInterface;
use Tokenly\Wp\Interfaces\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Shortcodes\LogoutButtonShortcodeInterface;
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
	//Controllers
	BalancesControllerInterface::class             => \DI\autowire( BalancesController::class ),
	TokenMetaControllerInterface::class            => \DI\autowire( TokenMetaController::class ),
	UserControllerInterface::class                 => \DI\autowire( UserController::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	ConnectionControllerInterface::class           => \DI\autowire( ConnectionController::class ),
	DashboardControllerInterface::class            => \DI\autowire( DashboardController::class ),
	PromiseControllerInterface::class              => \DI\autowire( PromiseController::class ),
	PostControllerInterface::class                 => \DI\autowire( PostController::class ),
	SettingsControllerInterface::class             => \DI\autowire( SettingsController::class )
		->constructorParameter( 'oauth_callback_route', \DI\get( 'oauth.callback_route' ) ),
	SourceControllerInterface::class               => \DI\autowire( SourceController::class ),
	VendorControllerInterface::class               => \DI\autowire( VendorController::class ),
	WhitelistControllerInterface::class            => \DI\autowire( WhitelistController::class ),
	//Controllers - API
	AuthApiControllerInterface::class                 => \DI\autowire( AuthApiController::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	PromiseApiControllerInterface::class              => \DI\autowire( PromiseApiController::class ),
	IntegrationSettingsApiControllerInterface::class  => \DI\autowire( IntegrationSettingsApiController::class ),
	TcaSettingsApiControllerInterface::class          => \DI\autowire( TcaSettingsApiController::class ),
	SourceApiControllerInterface::class               => \DI\autowire( SourceApiController::class ),
	UserApiControllerInterface::class                 => \DI\autowire( UserApiController::class ),
	WhitelistApiControllerInterface::class            => \DI\autowire( WhitelistApiController::class ),
	//Shortcodes
	LoginButtonShortcodeInterface::class              => \DI\autowire( LoginButtonShortcode::class ),
	LogoutButtonShortcodeInterface::class             => \DI\autowire( LogoutButtonShortcode::class ),
	//Components 
	ButtonLoginComponentInterface::class           => \DI\autowire( ButtonLoginComponent::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	ButtonLogoutComponentInterface::class          => \DI\autowire( ButtonLogoutComponent::class )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	CardTokenItemComponentInterface::class         => \DI\autowire( CardTokenItemComponent::class ),
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
	TcaServiceInterface::class                     => \DI\autowire( TcaService::class ),
	//Services - Domain
	AddressServiceInterface::class                 => \DI\autowire( AddressService::class ),
	BalanceServiceInterface::class                 => \DI\autowire( BalanceService::class ),
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
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'api_host', DI\get( 'api.host' ) ),
	ApiRouterInterface::class                      => \DI\autowire( ApiRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	PostTypeRouterInterface::class                 => \DI\autowire( PostTypeRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	WebRouterInterface::class                      => \DI\autowire( WebRouter::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Collections
	CollectionInterface::class               => \DI\autowire( Collection::class ),
	AddressCollectionInterface::class        => \DI\autowire( AddressCollection::class ),
	BalanceCollectionInterface::class        => \DI\autowire( BalanceCollection::class ),
	PromiseCollectionInterface::class        => \DI\autowire( PromiseCollection::class ),
	PromiseMetaCollectionInterface::class    => \DI\autowire( PromiseMetaCollection::class ),
	PostCollectionInterface::class           => \DI\autowire( PostCollection::class ),
	SourceCollectionInterface::class         => \DI\autowire( SourceCollection::class ),
	TokenMetaCollectionInterface::class      => \DI\autowire( TokenMetaCollection::class ),
	TcaRuleCollectionInterface::class        => \DI\autowire( TcaRuleCollection::class ),
	UserCollectionInterface::class           => \DI\autowire( UserCollection::class ),
	WhitelistItemCollectionInterface::class  => \DI\autowire( WhitelistItemCollection::class ),
	//Models
	AddressInterface::class                  => \DI\autowire( Address::class ),
	BalanceInterface::class                  => \DI\autowire( Balance::class ),
	CurrentUserInterface::class              => \DI\factory( function (
		ContainerInterface $container,
		UserServiceInterface $user_service
	) {
		$user_id = get_current_user_id();
		if ( $user_id == 0 ) {
			$user = $container->make( GuestUserInterface::class );
		} else {
			$user = $user_service->show( array(
				'id' => $user_id,
			) );
		}
		return $user;
	} ),
	OauthUserInterface::class              => \DI\autowire( OauthUser::class ),
	PostInterface::class                   => \DI\autowire( Post::class ),
	PromiseInterface::class                => \DI\autowire( Promise::class ),
	PromiseMetaInterface::class            => \DI\autowire( PromiseMeta::class ), 
	SourceInterface::class                 => \DI\autowire( Source::class ), 
	TokenMetaInterface::class              => \DI\autowire( TokenMeta::class ), 
	TcaRuleInterface::class                => \DI\autowire( TcaRule::class ), 
	UserInterface::class                   => \DI\autowire( User::class ),
	GuestUserInterface::class              => \DI\autowire( GuestUser::class ),
	WhitelistItemInterface::class          => \DI\autowire( WhitelistItem::class ),
	IntegrationInterface::class            => \DI\autowire( Integration::class ),
	IntegrationSettingsInterface::class    => \DI\autowire( IntegrationSettings::class ),
	TcaSettingsInterface::class            => \DI\autowire( TcaSettings::class ),
	WhitelistInterface::class              => \DI\autowire( Whitelist::class ),
	//Factories
	AddressFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, AddressInterface::class ) extends ConcreteFactory implements AddressFactoryInterface {};
	} ),
	BalanceFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, BalanceInterface::class ) extends ConcreteFactory implements BalanceFactoryInterface {};
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
	//Factories - abstract - collections
	AddressCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, AddressFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, AddressCollectionInterface::class ) extends ConcreteCollectionFactory implements AddressCollectionFactoryInterface {};
	} ),
	BalanceCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, BalanceFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, BalanceCollectionInterface::class ) extends ConcreteCollectionFactory implements BalanceCollectionFactoryInterface {};
	} ),
	PromiseCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, PromiseFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PromiseCollectionInterface::class ) extends ConcreteCollectionFactory implements PromiseCollectionFactoryInterface {};
	} ),
	PostCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, PostFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PostCollectionInterface::class ) extends ConcreteCollectionFactory implements PostCollectionFactoryInterface {};
	} ),
	PromiseMetaCollectionFactoryInterface::class    => \DI\factory( function( ContainerInterface $container, PromiseMetaFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PromiseMetaCollectionInterface::class ) extends ConcreteCollectionFactory implements PromiseMetaCollectionFactoryInterface {};
	} ),
	SourceCollectionFactoryInterface::class         => \DI\factory( function( ContainerInterface $container, SourceFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, SourceCollectionInterface::class ) extends ConcreteCollectionFactory implements SourceCollectionFactoryInterface {};
	} ),
	TokenMetaCollectionFactoryInterface::class      => \DI\factory( function( ContainerInterface $container, TokenMetaFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenMetaCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenMetaCollectionFactoryInterface {};
	} ),
	TcaRuleCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, TcaRuleFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TcaRuleCollectionInterface::class ) extends ConcreteCollectionFactory implements TcaRuleCollectionFactoryInterface {};
	} ),
	UserCollectionFactoryInterface::class           => \DI\factory( function( ContainerInterface $container, UserFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, UserCollectionInterface::class ) extends ConcreteCollectionFactory implements UserCollectionFactoryInterface {};
	} ),
	WhitelistItemCollectionFactoryInterface::class  => \DI\factory( function( ContainerInterface $container, WhitelistItemFactoryInterface $item_factory ) {
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
			'client_id',
			'client_secret',
		) );
		$client_id = $settings['client_id'] ?? null;
		$client_secret = $settings['client_secret'] ?? null;
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
			if ( is_a( $item, $this->class ) === false ) {
				$item = $this->item_factory->create( $item );
			}
		};
		$collection = $this->container->make( $this->class, array(
			'items' => $data,
		) );
		return $collection;
	}
}
