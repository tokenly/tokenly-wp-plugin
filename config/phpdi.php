<?php
use Psr\Container\ContainerInterface;
use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Tokenly\Wp\Services\AuthService;
use Tokenly\Wp\Services\LifecycleService;
use Tokenly\Wp\Services\ResourceService;
use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Repositories\AddressRepository;
use Tokenly\Wp\Repositories\BalanceRepository;
use Tokenly\Wp\Repositories\OauthUserRepository;
use Tokenly\Wp\Repositories\PromiseRepository;
use Tokenly\Wp\Repositories\IntegrationRepository;
use Tokenly\Wp\Repositories\IntegrationSettingsRepository;
use Tokenly\Wp\Repositories\SourceRepository;
use Tokenly\Wp\Repositories\UserRepository;
use Tokenly\Wp\Repositories\WhitelistRepository;
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
use Tokenly\Wp\Controllers\Api\SettingsController as SettingsApiController;
use Tokenly\Wp\Controllers\Api\SourceController as SourceApiController;
use Tokenly\Wp\Controllers\Api\UserController as UserApiController;
use Tokenly\Wp\Controllers\Api\WhitelistController as WhitelistApiController;
use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Collections\AddressCollection;
use Tokenly\Wp\Collections\BalanceCollection;
use Tokenly\Wp\Collections\PromiseCollection;
use Tokenly\Wp\Collections\PromiseMetaCollection;
use Tokenly\Wp\Collections\SourceCollection;
use Tokenly\Wp\Collections\TokenMetaCollection;
use Tokenly\Wp\Collections\UserCollection;
use Tokenly\Wp\Models\Address;
use Tokenly\Wp\Models\Balance;
use Tokenly\Wp\Models\OauthUser;
use Tokenly\Wp\Models\Promise;
use Tokenly\Wp\Models\PromiseMeta;
use Tokenly\Wp\Models\Integration;
use Tokenly\Wp\Models\IntegrationSettings;
use Tokenly\Wp\Models\Source;
use Tokenly\Wp\Models\TokenMeta;
use Tokenly\Wp\Models\User;
use Tokenly\Wp\Models\GuestUser;
use Tokenly\Wp\Models\Whitelist;
use Tokenly\Wp\Models\WhitelistItem;
use Tokenly\Wp\Factories\Models\AddressFactory;
use Tokenly\Wp\Factories\Models\BalanceFactory;
use Tokenly\Wp\Factories\Models\OauthUserFactory;
use Tokenly\Wp\Factories\Models\PromiseFactory;
use Tokenly\Wp\Factories\Models\PromiseMetaFactory;
use Tokenly\Wp\Factories\Models\SourceFactory;
use Tokenly\Wp\Factories\Models\TokenMetaFactory;
use Tokenly\Wp\Factories\Models\UserFactory;
use Tokenly\Wp\Factories\Models\WhitelistItemFactory;
use Tokenly\Wp\Factories\Collections\AddressCollectionFactory;
use Tokenly\Wp\Factories\Collections\BalanceCollectionFactory;
use Tokenly\Wp\Factories\Collections\PromiseCollectionFactory;
use Tokenly\Wp\Factories\Collections\PromiseMetaCollectionFactory;
use Tokenly\Wp\Factories\Collections\SourceCollectionFactory;
use Tokenly\Wp\Factories\Collections\TokenMetaCollectionFactory;
use Tokenly\Wp\Factories\Collections\UserCollectionFactory;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\PromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Post\TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\MetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;;
use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
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
use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface as SettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SourceControllerInterface as SourceApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface as UserApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\WhitelistControllerInterface as WhitelistApiControllerInterface;
use Tokenly\Wp\Interfaces\Factories\Models\AddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\BalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\SourceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\AddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\BalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\SourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Collections\AddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\BalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\SourceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Models\AddressInterface;
use Tokenly\Wp\Interfaces\Models\BalanceInterface;
use Tokenly\Wp\Interfaces\Models\CurrentUserInterface;
use Tokenly\Wp\Interfaces\Models\PromiseInterface;
use Tokenly\Wp\Interfaces\Models\PromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\SourceInterface;
use Tokenly\Wp\Interfaces\Models\TokenMetaInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistInterface;
use Tokenly\Wp\Interfaces\Models\WhitelistItemInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLoginComponentInterface;
use Tokenly\Wp\Interfaces\Components\ButtonLogoutComponentInterface;
use Tokenly\Wp\Interfaces\Components\CardTokenItemComponentInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

return array(
	//Variables
	'general.name'             => 'tokenly-wp-plugin',
	'general.namespace'        => 'tokenly',
	'general.version'          => '0.3-alpha',
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
	'oauth.callback_route'     => get_site_url() . '/tokenpass-oauth-callback',
	'oauth.host'               => \DI\factory( function( string $api_host ) {
		return $api_host . '/oauth/authorize';
	} )->parameter( 'api_host', \DI\get( 'api.host' ) ),
	//Providers
	AppServiceProviderInterface::class             => \DI\autowire( AppServiceProvider::class ),
	RouteServiceProviderInterface::class           => \DI\autowire( RouteServiceProvider::class ),
	ShortcodeServiceProviderInterface::class       => \DI\autowire( ShortcodeServiceProvider::class ),
	//Controllers
	BalancesControllerInterface::class             => \DI\autowire( BalancesController::class ),
	TokenMetaControllerInterface::class            => \DI\autowire( TokenMetaController::class ),
	UserControllerInterface::class                 => \DI\autowire( UserController::class ),
	ConnectionControllerInterface::class           => \DI\autowire( ConnectionController::class ),
	DashboardControllerInterface::class            => \DI\autowire( DashboardController::class ),
	PromiseControllerInterface::class              => \DI\autowire( PromiseController::class ),
	SettingsControllerInterface::class             => \DI\autowire( SettingsController::class )
		->constructorParameter( 'oauth_callback_route', DI\get( 'oauth.callback_route' ) ),
	SourceControllerInterface::class               => \DI\autowire( SourceController::class ),
	VendorControllerInterface::class               => \DI\autowire( VendorController::class ),
	WhitelistControllerInterface::class            => \DI\autowire( WhitelistController::class ),
	//Controllers - API
	AuthApiControllerInterface::class              => \DI\autowire( AuthApiController::class ),
	PromiseApiControllerInterface::class           => \DI\autowire( PromiseApiController::class ),
	SettingsApiControllerInterface::class          => \DI\autowire( SettingsApiController::class ),
	SourceApiControllerInterface::class            => \DI\autowire( SourceApiController::class ),
	UserApiControllerInterface::class              => \DI\autowire( UserApiController::class ),
	WhitelistApiControllerInterface::class         => \DI\autowire( WhitelistApiController::class ),
	//Components 
	ButtonLoginComponentInterface::class           => \DI\autowire( ButtonLoginComponent::class )
		->constructorParameter( 'root_dir', DI\get( 'general.root_dir' ) ),
	ButtonLogoutComponentInterface::class          => \DI\autowire( ButtonLogoutComponent::class )
		->constructorParameter( 'root_dir', DI\get( 'general.root_dir' ) ),
	CardTokenItemComponentInterface::class         => \DI\autowire( CardTokenItemComponent::class ),
	//Services
	AuthServiceInterface::class                    => \DI\autowire( AuthService::class )
		->constructorParameter( 'oauth_callback_route', \DI\get('oauth.callback_route') ),
	LifecycleServiceInterface::class               => \DI\autowire( LifecycleService::class )
		->constructorParameter( 'version', \DI\get( 'general.version' ) )
		->constructorParameter( 'root_filepath', \DI\get( 'general.root_filepath' ) ),
	ResourceServiceInterface::class                => \DI\autowire( ResourceService::class )
		->constructorParameter( 'root_url', \DI\get( 'general.root_url' ) )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	UserServiceInterface::class                    => \DI\autowire( UserService::class ),
	//Repositories
	AddressRepositoryInterface::class              => \DI\autowire( AddressRepository::class ),
	BalanceRepositoryInterface::class              => \DI\autowire( BalanceRepository::class ),
	MetaRepositoryInterface::class                 => \DI\autowire( MetaRepository::class ),
	OauthUserRepositoryInterface::class            => \DI\autowire( OauthUserRepository::class ),
	OptionRepositoryInterface::class               => \DI\autowire( OptionRepository::class ),
	PromiseRepositoryInterface::class              => \DI\autowire( PromiseRepository::class ),
	PromiseMetaRepositoryInterface::class          => \DI\autowire( PromiseMetaRepository::class ),
	IntegrationRepositoryInterface::class          => \DI\autowire( IntegrationRepository::class ),
	IntegrationSettingsRepositoryInterface::class  => \DI\autowire( IntegrationSettingsRepository::class ),
	SourceRepositoryInterface::class               => \DI\autowire( SourceRepository::class ),
	TokenMetaRepositoryInterface::class            => \DI\autowire( TokenMetaRepository::class ),
	UserRepositoryInterface::class                 => \DI\autowire( UserRepository::class ),
	WhitelistRepositoryInterface::class            => \DI\autowire( WhitelistRepository::class ),
	UserMetaRepositoryInterface::class             => \DI\autowire( UserMetaRepository::class ),
	//Routes
	AdminRouterInterface::class                    => \DI\autowire( AdminRouter::class )
		->constructorParameter( 'root_dir', DI\get( 'general.root_dir' ) ),
	ApiRouterInterface::class                      => \DI\autowire( ApiRouter::class ),
	PostTypeRouterInterface::class                 => \DI\autowire( PostTypeRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	WebRouterInterface::class                      => \DI\autowire( WebRouter::class ),
	//Collections
	CollectionInterface::class                     => \DI\autowire( Collection::class ),
	AddressCollectionInterface::class              => \DI\autowire( AddressCollection::class ),
	BalanceCollectionInterface::class              => \DI\autowire( BalanceCollection::class ),
	PromiseCollectionInterface::class              => \DI\autowire( PromiseCollection::class ),
	PromiseMetaCollectionInterface::class          => \DI\autowire( PromiseMetaCollection::class ),
	SourceCollectionInterface::class               => \DI\autowire( SourceCollection::class ),
	TokenMetaCollectionInterface::class            => \DI\autowire( TokenMetaCollection::class ),
	UserCollectionInterface::class                 => \DI\autowire( UserCollection::class ),
	//Models
	AddressInterface::class                        => \DI\autowire( Address::class ),
	BalanceInterface::class                        => \DI\autowire( Balance::class ),
	OauthUserInterface::class                      => \DI\autowire( OauthUser::class ),
	PromiseInterface::class                        => \DI\autowire( Promise::class ),
	PromiseMetaInterface::class                    => \DI\autowire( PromiseMeta::class ), 
	SourceInterface::class                         => \DI\autowire( Source::class ), 
	TokenMetaInterface::class                      => \DI\autowire( TokenMeta::class ), 
	UserInterface::class                           => \DI\autowire( User::class ),
	WhitelistItemInterface::class                  => \DI\autowire( WhitelistItem::class ),
	//Models - single instance
	CurrentUserInterface::class                => function (
		ContainerInterface $container,
		UserRepositoryInterface $user_repository
	) {
		$user_id = get_current_user_id();
		if ( $user_id == 0 ) {
			$user = $container->make( GuestUser::class );
		} else {
			$user = $user_repository->show( array(
				'id' => $user_id,
			) );
		}
		return $user;
	},
	IntegrationInterface::class                => function ( 
		ContainerInterface $container
	) {
		$integration = $container->make( Integration::class );
		return $integration;
	},
	IntegrationSettingsInterface::class        => function ( 
		ContainerInterface $container,
		IntegrationSettingsRepositoryInterface $integration_settings_repository
	) {
		$settings_data = $integration_settings_repository->show();
		$settings = $container->make( IntegrationSettings::class, array(
			'settings_data' => $settings_data,
		) );
		return $settings;
	},
	WhitelistInterface::class                  => function ( 
		ContainerInterface $container,
		WhitelistRepositoryInterface $whitelist_repository
	) {
		$whitelist_data = $whitelist_repository->show();
		$whitelist = $container->make( Whitelist::class, array(
			'whitelist_data' => $whitelist_data,
		) );
		return $whitelist;
	},
	//Factories - concrete - models
	AddressFactoryConcrete::class                => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', AddressInterface::class ),
	BalanceFactoryConcrete::class                => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', BalanceInterface::class ),
	OauthUserFactoryConcrete::class              => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', OauthUserInterface::class ),
	PromiseFactoryConcrete::class                => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', PromiseInterface::class ),
	PromiseMetaFactoryConcrete::class            => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', PromiseMetaInterface::class ),
	SourceFactoryConcrete::class                 => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', SourceInterface::class ),
	TokenMetaFactoryConcrete::class              => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', TokenMetaInterface::class ),
	UserFactoryConcrete::class                   => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', UserInterface::class ),
	WhitelistItemFactoryConcrete::class          => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', WhitelistItemInterface::class ),
	//Factories - concrete - collections
	AddressCollectionFactoryConcrete::class      => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', AddressCollectionInterface::class ),
	BalanceCollectionFactoryConcrete::class      => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', BalanceCollectionInterface::class ),
	PromiseCollectionFactoryConcrete::class      => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', PromiseCollectionInterface::class ),
	PromiseMetaCollectionFactoryConcrete::class  => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', PromiseMetaCollectionInterface::class ),
	SourceCollectionFactoryConcrete::class       => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', SourceCollectionInterface::class ),
	TokenMetaCollectionFactoryConcrete::class    => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', TokenMetaCollectionInterface::class ),
	UserCollectionFactoryConcrete::class         => \DI\autowire( RootFactory::class )
		->constructorParameter( 'class', UserCollectionInterface::class ),
	//Factories - abstract - models
	AddressFactoryInterface::class               => \DI\autowire( AddressFactory::class )
		->constructorParameter( 'factory', \Di\get( AddressFactoryConcrete::class ) ),
	BalanceFactoryInterface::class               => \DI\autowire( BalanceFactory::class )
		->constructorParameter( 'factory', \Di\get( BalanceFactoryConcrete::class ) ),
	OauthUserFactoryInterface::class             => \DI\autowire( OauthUserFactory::class )
		->constructorParameter( 'factory', \Di\get( OauthUserFactoryConcrete::class ) ),
	PromiseFactoryInterface::class               => \DI\autowire( PromiseFactory::class )
		->constructorParameter( 'factory', \Di\get( PromiseFactoryConcrete::class ) ),
	PromiseMetaFactoryInterface::class           => \DI\autowire( PromiseMetaFactory::class )
		->constructorParameter( 'factory', \Di\get( PromiseMetaFactoryConcrete::class ) ),
	SourceFactoryInterface::class                => \DI\autowire( SourceFactory::class )
		->constructorParameter( 'factory', \Di\get( SourceFactoryConcrete::class ) ),
	TokenMetaFactoryInterface::class             => \DI\autowire( TokenMetaFactory::class )
		->constructorParameter( 'factory', \Di\get( TokenMetaFactoryConcrete::class ) ),
	UserFactoryInterface::class                  => \DI\autowire( UserFactory::class )
		->constructorParameter( 'factory', \Di\get( UserFactoryConcrete::class ) ),
	WhitelistItemFactoryInterface::class         => \DI\autowire( WhitelistItemFactory::class )
		->constructorParameter( 'factory', \Di\get( WhitelistItemFactoryConcrete::class ) ),
	//Factories - abstract - collections
	AddressCollectionFactoryInterface::class     => \DI\autowire( AddressCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( AddressCollectionFactoryConcrete::class ) ),
	BalanceCollectionFactoryInterface::class     => \DI\autowire( BalanceCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( BalanceCollectionFactoryConcrete::class ) ),
	PromiseCollectionFactoryInterface::class     => \DI\autowire( PromiseCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( PromiseCollectionFactoryConcrete::class ) ),
	PromiseMetaCollectionFactoryInterface::class => \DI\autowire( PromiseMetaCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( PromiseMetaCollectionFactoryConcrete::class ) ),
	SourceCollectionFactoryInterface::class      => \DI\autowire( SourceCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( SourceCollectionFactoryConcrete::class ) ),
	TokenMetaCollectionFactoryInterface::class   => \DI\autowire( TokenMetaCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( TokenMetaCollectionFactoryConcrete::class ) ),
	UserCollectionFactoryInterface::class        => \DI\autowire( UserCollectionFactory::class )
		->constructorParameter( 'factory', \Di\get( UserCollectionFactoryConcrete::class ) ),
	//Third-party
	TokenpassAPI::class => \DI\factory( function ( 
		ContainerInterface $container,
		IntegrationSettingsInterface $settings,
		string $api_host,
		string $oauth_callback_route
	) {
		$client_id = $settings->client_id ?? null;
		$client_secret = $settings->client_secret ?? null;
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

class RootFactory {
	protected $container;
	protected $class;

	public function __construct( ContainerInterface $container, $class ) {
		$this->container = $container;
		$this->class = $class;
	}

	public function create( $params ) {
		return $this->container->make( $this->class, $params );
	}
}
