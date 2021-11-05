<?php
use Psr\Container\ContainerInterface;
use Tokenly\Wp\Decorators\UserDecorator;
use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Tokenly\Wp\Services\AuthService;
use Tokenly\Wp\Services\BalanceService;
use Tokenly\Wp\Services\UserService;
use Tokenly\Wp\Repositories\AddressRepository;
use Tokenly\Wp\Repositories\BalanceRepository;
use Tokenly\Wp\Repositories\PromiseRepository;
use Tokenly\Wp\Repositories\SettingsRepository;
use Tokenly\Wp\Repositories\SourceRepository;
use Tokenly\Wp\Repositories\UserRepository;
use Tokenly\Wp\Repositories\WhitelistRepository;
use Tokenly\Wp\Repositories\Post\TokenMetaRepository;
use Tokenly\Wp\Repositories\General\MetaRepository;
use Tokenly\Wp\Repositories\General\OptionRepository;
use Tokenly\Wp\Repositories\General\UserMetaRepository;
use Tokenly\Wp\Routes\AdminRouter;
use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\Wp\Routes\PostTypeRouter;
use Tokenly\Wp\Routes\WebRouter;
use Tokenly\Wp\Controllers\Web\TokenMetaController;
use Tokenly\Wp\Controllers\Web\UserController;
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
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\BalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\UserServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\AddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\BalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\SourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\WhitelistRepositoryInterface;
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
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

return array(
	//Providers
	AppServiceProviderInterface::class        => \DI\autowire( AppServiceProvider::class ),
	RouteServiceProviderInterface::class      => \DI\autowire( RouteServiceProvider::class ),
	ShortcodeServiceProviderInterface::class  => \DI\autowire( ShortcodeServiceProvider::class ),
	//Controllers
	TokenMetaControllerInterface::class       => \DI\autowire( TokenMetaController::class ),
	UserControllerInterface::class            => \DI\autowire( UserController::class ),
	ConnectionControllerInterface::class      => \DI\autowire( ConnectionController::class ),
	DashboardControllerInterface::class       => \DI\autowire( DashboardController::class ),
	PromiseControllerInterface::class         => \DI\autowire( PromiseController::class ),
	SettingsControllerInterface::class        => \DI\autowire( SettingsController::class ),
	SourceControllerInterface::class          => \DI\autowire( SourceController::class ),
	VendorControllerInterface::class          => \DI\autowire( VendorController::class ),
	WhitelistControllerInterface::class       => \DI\autowire( WhitelistController::class ),
	//Controllers - API
	AuthApiControllerInterface::class         => \DI\autowire( AuthApiController::class ),
	PromiseApiControllerInterface::class      => \DI\autowire( PromiseApiController::class ),
	SettingsApiControllerInterface::class     => \DI\autowire( SettingsApiController::class ),
	SourceApiControllerInterface::class       => \DI\autowire( SourceApiController::class ),
	UserApiControllerInterface::class         => \DI\autowire( UserApiController::class ),
	WhitelistApiControllerInterface::class    => \DI\autowire( WhitelistApiController::class ),
	//Services
	AuthServiceInterface::class               => \DI\autowire( AuthService::class ),
	BalanceServiceInterface::class            => \DI\autowire( BalanceService::class ),
	UserServiceInterface::class               => \DI\autowire( UserService::class ),
	//Repositories
	AddressRepositoryInterface::class         => \DI\autowire( AddressRepository::class ),
	BalanceRepositoryInterface::class         => \DI\autowire( BalanceRepository::class ),
	PromiseRepositoryInterface::class         => \DI\autowire( PromiseRepository::class ),
	SettingsRepositoryInterface::class        => \DI\autowire( SettingsRepository::class ),
	SourceRepositoryInterface::class          => \DI\autowire( SourceRepository::class ),
	UserRepositoryInterface::class            => \DI\autowire( UserRepository::class ),
	WhitelistRepositoryInterface::class       => \DI\autowire( WhitelistRepository::class ),
	TokenMetaRepositoryInterface::class       => \DI\autowire( TokenMetaRepository::class ),
	MetaRepositoryInterface::class            => \DI\autowire( MetaRepository::class ),
	OptionRepositoryInterface::class          => \DI\autowire( OptionRepository::class ),
	UserMetaRepositoryInterface::class        => \DI\autowire( UserMetaRepository::class ),
	//Routes
	AdminRouterInterface::class               => \DI\autowire( AdminRouter::class ),
	ApiRouterInterface::class                 => \DI\autowire( ApiRouter::class ),
	PostTypeRouterInterface::class            => \DI\autowire( PostTypeRouter::class ),
	WebRouterInterface::class                 => \DI\autowire( WebRouter::class ),
	//Third-party
	TokenpassAPI::class => function ( 
		ContainerInterface $container,
		SettingsRepositoryInterface $settings_repository
	) {
		$client_id = '';
		$client_secret = '';
		$privileged_client_id = '';
		$privileged_client_secret = '';
		$oauth_client_id = '';
		$oauth_client_secret = '';
		$settings = $settings_repository->show();
		if ( $settings ) {
			$client_id = $settings['client_id'] ?? null;
			$client_secret = $settings['client_secret'] ?? null;
			$privileged_client_id = $client_id;
			$privileged_client_secret = $client_secret;
			$oauth_client_id = $client_id;
			$oauth_client_secret = $client_secret;
		}
		$tokenpass_url = 'https://tokenpass.tokenly.com';
		$redirect_uri = TOKENLY_PLUGIN_AUTH_REDIRECT_URI;
		$client = new TokenpassAPI( 
			$client_id,
			$client_secret,
			$privileged_client_id,
			$privileged_client_secret,
			$tokenpass_url,
			$redirect_uri,
			$oauth_client_id,
			$oauth_client_secret
		);
		return $client;
	},
	TokenpassAPIInterface::class => DI\get( TokenpassAPI::class ),
	Environment::class => function () {
		$loader = new FilesystemLoader( TOKENLY_PLUGIN_TEMPLATE_DIR );
		$twig = new Environment( $loader, array(
			// 'cache' => TOKENLY_PLUGIN_TEMPLATE_CACHE_DIR,
			'cache' => false,
		) );
		return $twig;
	},
);
