<?php

use Psr\Container\ContainerInterface;

use Tokenly\Wp\Controllers\Admin\DashboardController
	as DashboardAdminController;
use Tokenly\Wp\Controllers\Admin\SettingsController
	as SettingsAdminController;
use Tokenly\Wp\Controllers\Admin\UserController
	as UserAdminController;
use Tokenly\Wp\Controllers\Admin\PostController
	as PostAdminController;
use Tokenly\Wp\Controllers\Admin\TermController
	as TermAdminController;
use Tokenly\Wp\Controllers\Admin\Credit\GroupController
	as CreditGroupAdminController;
use Tokenly\Wp\Controllers\Admin\Credit\TransactionController
	as CreditTransactionAdminController;
use Tokenly\Wp\Controllers\Admin\Credit\VendorController
	as CreditVendorAdminController;
use Tokenly\Wp\Controllers\Admin\Token\AddressController
	as TokenAddressAdminController;
use Tokenly\Wp\Controllers\Admin\Token\SourceController
	as TokenSourceAdminController;
use Tokenly\Wp\Controllers\Admin\Token\VendorController
	as TokenVendorAdminController;
use Tokenly\Wp\Controllers\Admin\Token\PromiseController
	as TokenPromiseAdminController;
use Tokenly\Wp\Controllers\Admin\Token\WhitelistController
	as TokenWhitelistAdminController;
use Tokenly\Wp\Controllers\Admin\Token\MetaController
	as TokenMetaAdminController;
use Tokenly\Wp\Controllers\Admin\Token\CategoryTermController
	as TokenCategoryTermAdminController;
use Tokenly\Wp\Controllers\Api\AuthController
	as AuthApiController;
use Tokenly\Wp\Controllers\Api\SettingsController
	as SettingsApiController;
use Tokenly\Wp\Controllers\Api\UserController
	as UserApiController;
use Tokenly\Wp\Controllers\Api\Credit\GroupController
	as CreditGroupApiController;
use Tokenly\Wp\Controllers\Api\Credit\TransactionController
	as CreditTransactionApiController;
use Tokenly\Wp\Controllers\Api\Credit\VendorController
	as CreditVendorApiController;
use Tokenly\Wp\Controllers\Api\Token\AddressController
	as TokenAddressApiController;
use Tokenly\Wp\Controllers\Api\Token\BalanceController
	as TokenBalanceApiController;
use Tokenly\Wp\Controllers\Api\Token\PromiseController
	as TokenPromiseApiController;
use Tokenly\Wp\Controllers\Api\Token\SourceController
	as TokenSourceApiController;
use Tokenly\Wp\Controllers\Api\Token\VendorController
	as TokenVendorApiController;
use Tokenly\Wp\Controllers\Api\Token\WhitelistController
	as TokenWhitelistApiController;
use Tokenly\Wp\Controllers\Api\User\Credit\BalanceController
	as UserCreditBalanceApiController;
use Tokenly\Wp\Controllers\Api\User\Token\BalanceController
	as UserTokenBalanceApiController;
use Tokenly\Wp\Controllers\Web\AuthController;
use Tokenly\Wp\Controllers\Web\UserController;
use Tokenly\Wp\Controllers\Web\PostController;
use Tokenly\Wp\Policies\Admin\Credit\GroupPolicy
	as CreditGroupPolicy;
use Tokenly\Wp\Policies\Admin\Credit\TransactionPolicy
	as CreditTransactionPolicy;
use Tokenly\Wp\Policies\Admin\Credit\VendorPolicy
	as CreditVendorPolicy;
use Tokenly\Wp\Policies\Admin\Token\AddressPolicy
	as TokenAddressPolicy;
use Tokenly\Wp\Policies\Admin\Token\CategoryTermPolicy
	as TokenCategoryTermPolicy;
use Tokenly\Wp\Policies\Admin\Token\MetaPolicy
	as TokenMetaPolicy;
use Tokenly\Wp\Policies\Admin\Token\PromisePolicy
	as TokenPromisePolicy;
use Tokenly\Wp\Policies\Admin\Token\SourcePolicy
	as TokenSourcePolicy;
use Tokenly\Wp\Policies\Admin\Token\VendorPolicy
	as TokenVendorPolicy;
use Tokenly\Wp\Policies\Admin\Token\WhitelistPolicy
	as TokenWhitelistPolicy;
use Tokenly\Wp\Policies\Admin\DashboardPolicy;
use Tokenly\Wp\Policies\Admin\PostPolicy;
use Tokenly\Wp\Policies\Admin\SettingsPolicy;
use Tokenly\Wp\Policies\Admin\TermPolicy;
use Tokenly\Wp\Policies\Admin\UserPolicy;
use Tokenly\Wp\Presentation\Blocks\UserInfoBlockModel;
use Tokenly\Wp\Presentation\Blocks\Credit\ItemCardListBlockModel
	as CreditItemCardListBlockModel;
use Tokenly\Wp\Presentation\Blocks\Token\ItemCardListBlockModel
	as TokenItemCardListBlockModel;
use Tokenly\Wp\Presentation\Components\LoginButtonComponentModel;
use Tokenly\Wp\Presentation\Components\LogoutButtonComponentModel;
use Tokenly\Wp\Presentation\Components\Credit\ItemCardComponentModel
	as CreditItemCardComponentModel;
use Tokenly\Wp\Presentation\Components\Token\ItemCardComponentModel
	as TokenItemCardComponentModel;
use Tokenly\Wp\Presentation\Columns\TokenMetaFeaturedImageColumn;
use Tokenly\Wp\Presentation\Columns\UserCreditBalanceColumn;
use Tokenly\Wp\Presentation\Views\Admin\PostEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\TermEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\DashboardViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SettingsViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Credit\GroupStoreViewModel
	as CreditGroupStoreViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Credit\GroupWhitelistEditViewModel
	as CreditGroupWhitelistEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Token\WhitelistEditViewModel
	as TokenWhitelistEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Token\MetaEditViewModel
	as TokenMetaEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Token\CategoryTermEditViewModel
	as TokenCategoryTermEditViewModel;
use Tokenly\Wp\Presentation\Views\Web\PostAccessDeniedViewModel;
use Tokenly\Wp\Presentation\Views\Web\UserViewModel;
use Tokenly\Wp\Presentation\Shortcodes\LogoutButtonShortcode;
use Tokenly\Wp\Presentation\Shortcodes\LoginButtonShortcode;
use Tokenly\Wp\Presentation\Shortcodes\InventoryShortcode;
use Tokenly\Wp\Presentation\Shortcodes\UserInfoShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Credit\BalanceShortcode
	as CreditBalanceShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Credit\InventoryShortcode
	as CreditInventoryShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Token\BalanceShortcode
	as TokenBalanceShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Token\InventoryShortcode
	as TokenInventoryShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Token\MetaShortcode
	as TokenMetaShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Token\MetaAttributesShortcode
	as TokenMetaAttributesShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Token\MetaMediaShortcode
	as TokenMetaMediaShortcode;
use Tokenly\Wp\Presentation\Shortcodes\Token\MetaInfoShortcode
	as TokenMetaInfoShortcode;
use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\ListingServiceProvider;
use Tokenly\Wp\Providers\ServiceServiceProvider;
use Tokenly\Wp\Providers\PostTypeServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Tokenly\Wp\Providers\TaxonomyServiceProvider;
use Tokenly\Wp\Repositories\OauthUserRepository;
use Tokenly\Wp\Repositories\PostRepository;
use Tokenly\Wp\Repositories\TermRepository;
use Tokenly\Wp\Repositories\UserRepository;
use Tokenly\Wp\Repositories\Credit\AccountRepository
	as CreditAccountRepository;
use Tokenly\Wp\Repositories\Credit\GroupRepository
	as CreditGroupRepository;
use Tokenly\Wp\Repositories\Credit\GroupWhitelistRepository
	as CreditGroupWhitelistRepository;
use Tokenly\Wp\Repositories\Credit\TransactionRepository
	as CreditTransactionRepository;
use Tokenly\Wp\Repositories\General\PostMetaRepository;
use Tokenly\Wp\Repositories\General\OptionRepository;
use Tokenly\Wp\Repositories\General\TermMetaRepository;
use Tokenly\Wp\Repositories\General\UserMetaRepository;
use Tokenly\Wp\Repositories\Token\AddressRepository
	as TokenAddressRepository;
use Tokenly\Wp\Repositories\Token\BalanceRepository
	as TokenBalanceRepository;
use Tokenly\Wp\Repositories\Token\CategoryTermRepository
	as TokenCategoryTermRepository;
use Tokenly\Wp\Repositories\Token\PromiseRepository
	as TokenPromiseRepository;
use Tokenly\Wp\Repositories\Token\PromiseMetaRepository
	as TokenPromiseMetaRepository;
use Tokenly\Wp\Repositories\Token\SourceRepository
	as TokenSourceRepository;
use Tokenly\Wp\Repositories\Token\MetaRepository
	as TokenMetaRepository;
use Tokenly\Wp\Repositories\Token\WhitelistRepository
	as TokenWhitelistRepository;
use Tokenly\Wp\Repositories\Settings\IntegrationSettingsRepository;
use Tokenly\Wp\Repositories\Settings\OauthSettingsRepository;
use Tokenly\Wp\Repositories\Settings\TcaSettingsRepository;
use Tokenly\Wp\Repositories\Routes\AdminRouteRepository;
use Tokenly\Wp\Repositories\Routes\ApiRouteRepository;
use Tokenly\Wp\Repositories\Routes\PostRouteRepository;
use Tokenly\Wp\Repositories\Routes\TermRouteRepository;
use Tokenly\Wp\Repositories\Routes\WebRouteRepository;
use Tokenly\Wp\Services\Application\AuthService;
use Tokenly\Wp\Services\Application\LifecycleService;
use Tokenly\Wp\Services\Application\ResourceService;
use Tokenly\Wp\Services\Application\QueryService;
use Tokenly\Wp\Services\Application\Credit\VendorService
	as CreditVendorService;
use Tokenly\Wp\Services\Application\Token\VendorService
	as TokenVendorService;
use Tokenly\Wp\Services\Application\Token\Access\CheckerService
	as TokenAccessCheckerService;
use Tokenly\Wp\Services\Application\Token\Access\MenuItemFilterService
	as TokenAccessMenuItemFilterService;
use Tokenly\Wp\Services\Application\Token\Access\PostCheckerService
	as TokenAccessPostCheckerService;
use Tokenly\Wp\Services\Application\Token\Access\PostGuardService
	as TokenAccessPostGuardService;
use Tokenly\Wp\Services\Application\Token\Access\PostResultsFilterService
	as TokenAccessPostResultsFilterService;
use Tokenly\Wp\Services\Application\Token\Access\TermCheckerService
	as TokenAccessTermCheckerService;
use Tokenly\Wp\Services\Application\Token\Access\TermGuardService
	as TokenAccessTermGuardService;
use Tokenly\Wp\Services\Application\Routers\Router;
use Tokenly\Wp\Services\Application\Routers\AdminRouter;
use Tokenly\Wp\Services\Application\Routers\ApiRouter;
use Tokenly\Wp\Services\Application\Routers\PostRouter;
use Tokenly\Wp\Services\Application\Routers\TermRouter;
use Tokenly\Wp\Services\Application\Routers\WebRouter;
use Tokenly\Wp\Services\Application\Routers\Columns\PostRouter
	as PostColumnRouter;
use Tokenly\Wp\Services\Application\Routers\Columns\UserRouter
	as UserColumnRouter;
use Tokenly\Wp\Services\Domain\Token\AssetNameFormatterService;
use Tokenly\Wp\Services\Domain\Token\QuantityCalculatorService;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface
	as CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface
	as CreditGroupCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface
	as CreditTransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCheckResultCollectionInterface
	as TcaRuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionInterface
	as TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface
	as TokenAddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AssetCollectionInterface
	as TokenAssetCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface
	as TokenBalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface
	as TokenPromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseMetaCollectionInterface
	as TokenPromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface
	as TokenSourceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface
	as TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\WhitelistItemCollectionInterface
	as TokenWhitelistItemCollectionInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface
	as AuthApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface
	as SettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface
	as UserApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface
	as CreditGroupApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface
	as CreditTransactionApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\VendorControllerInterface
	as CreditVendorApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface
	as TokenAddressApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface
	as TokenPromiseApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface
	as TokenSourceApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\VendorControllerInterface
	as TokenVendorApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\DashboardControllerInterface
	as DashboardAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\SettingsControllerInterface
	as SettingsAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\UserControllerInterface
	as UserAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\PostControllerInterface
	as PostAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\TermControllerInterface
	as TermAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\GroupControllerInterface
	as CreditGroupAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\TransactionControllerInterface
	as CreditTransactionAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Credit\VendorControllerInterface
	as CreditVendorAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\AddressControllerInterface
	as TokenAddressAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\PromiseControllerInterface
	as TokenPromiseAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\SourceControllerInterface
	as TokenSourceAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\VendorControllerInterface
	as TokenVendorAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\WhitelistControllerInterface
	as TokenWhitelistAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\MetaControllerInterface
	as TokenMetaAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Admin\Token\CategoryTermControllerInterface
	as TokenCategoryTermAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\DashboardPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\PostPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\SettingsPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\TermPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\UserPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\GroupPolicyInterface
	as CreditGroupPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\TransactionPolicyInterface
	as CreditTransactionPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Credit\VendorPolicyInterface
	as CreditVendorPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\AddressPolicyInterface
	as TokenAddressPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\CategoryTermPolicyInterface
	as TokenCategoryTermPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\MetaPolicyInterface
	as TokenMetaPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\PromisePolicyInterface
	as TokenPromisePolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\SourcePolicyInterface
	as TokenSourcePolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\VendorPolicyInterface
	as TokenVendorPolicyInterface;
use Tokenly\Wp\Interfaces\Policies\Admin\Token\WhitelistPolicyInterface
	as TokenWhitelistPolicyInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\Credit\ItemCardListBlockModelInterface
	as CreditItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\Token\ItemCardListBlockModelInterface
	as TokenItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Columns\TokenMetaFeaturedImageColumnInterface;
use Tokenly\Wp\Interfaces\Presentation\Columns\UserCreditBalanceColumnInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\Credit\ItemCardComponentModelInterface
	as CreditItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\Token\ItemCardComponentModelInterface
	as TokenItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\InventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\UserInfoShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Credit\BalanceShortcodeInterface
	as CreditBalanceShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Credit\InventoryShortcodeInterface
	as CreditInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\BalanceShortcodeInterface
	as TokenBalanceShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\InventoryShortcodeInterface
	as TokenInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaShortcodeInterface
	as TokenMetaShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaInfoShortcodeInterface
	as TokenMetaInfoShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaAttributesShortcodeInterface
	as TokenMetaAttributesShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\Token\MetaMediaShortcodeInterface
	as TokenMetaMediaShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PostEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TermEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SettingsViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface
	as CreditGroupStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupWhitelistEditViewModelInterface
	as CreditGroupWhitelistEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\WhitelistEditViewModelInterface
	as TokenWhitelistEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\MetaEditViewModelInterface
	as TokenMetaEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\CategoryTermEditViewModelInterface
	as TokenCategoryTermEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\PostAccessDeniedViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Web\UserViewModelInterface;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ListingServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ServiceServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\PostTypeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\TaxonomyServiceProviderInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface
	as CreditAccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface
	as CreditGroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupWhitelistRepositoryInterface
	as CreditGroupWhitelistRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface
	as CreditTransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface
	as TokenAddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface
	as TokenBalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\CategoryTermRepositoryInterface
	as TokenCategoryTermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface
	as TokenPromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface
	as TokenSourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseMetaRepositoryInterface
	as TokenPromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface
	as TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\WhitelistRepositoryInterface
	as TokenWhitelistRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\TermMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\IntegrationSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\OauthSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Settings\TcaSettingsRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\AdminRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\ApiRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\PostRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\TermRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Routes\WebRouteRepositoryInterface;
use Tokenly\Wp\Interfaces\Services\Application\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Credit\VendorServiceInterface
	as CreditVendorServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\PostRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\RouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\TermRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\WebRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\PostRouterInterface
	as PostColumnRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Routers\Listings\UserRouterInterface
	as UserColumnRouterInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\VendorServiceInterface
	as TokenVendorServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\CheckerServiceInterface
	as TokenAccessCheckerInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\MenuItemFilterServiceInterface
	as TokenAccessMenuItemFilterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostCheckerServiceInterface
	as TokenAccessPostCheckerServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostGuardServiceInterface
	as TokenAccessPostGuardServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\PostResultsFilterServiceInterface
	as TokenAccessPostResultsFilterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermCheckerServiceInterface
	as TokenAccessTermCheckerServiceInterface;
use Tokenly\Wp\Interfaces\Services\Application\Token\Access\TermGuardServiceInterface
	as TokenAccessTermGuardServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AssetNameFormatterServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\QuantityCalculatorServiceInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Tokenly\TokenpassClient\TokenpassAPI;
use Tokenly\TokenpassClient\TokenpassAPIInterface;

return array(
	'general.name'      => 'tokenly-wp-plugin',
	'general.version'   => '0.7',
	'general.namespace' => 'tokenly',
	'general.brand'     => 'Tokenly',
	'general.logo'      => \DI\factory(
		function( string $namespace, string $root_dir ) {
			$path = "{$root_dir}/resources/images/{$namespace}_logo.svg";
			$svg = base64_encode( file_get_contents( $path ) );
			return "data:image/svg+xml;base64,{$svg}";
		} )
		->parameter( 'namespace', \DI\get( 'general.namespace' ) )
		->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'general.fallback_image' => \DI\factory(
		function( string $root_url ) {
			return "{$root_url}/resources/images/placeholder.png";
		} )
		->parameter( 'root_url', \DI\get( 'general.root_url' ) ),
	'general.wp_plugin_dir' => \DI\factory( function() {
		return WP_PLUGIN_DIR;
	} ),
	'general.wp_plugin_url' => \DI\factory( function() {
		return WP_PLUGIN_URL;
	} ),
	'general.root_dir' => \DI\factory( 
		function( string $name, string $wp_plugin_dir ) {
			return "{$wp_plugin_dir}/{$name}";
		} )
		->parameter( 'name', \DI\get( 'general.name' ) )
		->parameter( 'wp_plugin_dir', \DI\get( 'general.wp_plugin_dir' ) ),
	'general.root_url' => \DI\factory(
		function( string $name, string $wp_plugin_url ) {
			return "{$wp_plugin_url}/{$name}";
		} )
		->parameter( 'name', \DI\get( 'general.name' ) )
		->parameter( 'wp_plugin_url', \DI\get( 'general.wp_plugin_url' ) ),
	'general.root_filepath'    => \DI\factory(
		function( string $root_dir, string $namespace ) {
			return "{$root_dir}/{$namespace}-wp-plugin.php";
		} )
		->parameter( 'root_dir', \DI\get( 'general.root_dir' ) )
		->parameter( 'namespace', \DI\get( 'general.namespace' ) ),
	'general.text_domain'      => \DI\factory(
		function( string $namespace ) {
			return "{$namespace}-wp-plugin";
		} )
		->parameter( 'namespace', \DI\get( 'general.namespace' ) ),
	'admin.url' => \DI\factory( function() { return admin_url(); } )
		->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'admin.page_url' => \DI\factory( function( string $admin_url ) {
		return "{$admin_url}admin.php?page=";
	} )->parameter( 'admin_url', \DI\get( 'admin.url' ) ),
	'api.host' => 'https://tokenpass.tokenly.com',
	'twig.template_dir' => \DI\factory( function( string $root_dir ) {
		return "{$root_dir}/resources/views/";
	} )->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'twig.template_cache_dir' => \DI\factory( function( string $root_dir ) {
		return "{$root_dir}/build/template-cache/";
	} )->parameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	'oauth.callback_route' => \DI\factory( function( string $namespace ) {
		$site_url = get_site_url();
		return "{$site_url}/{$namespace}/oauth/callback";
	} )->parameter( 'namespace', \DI\get( 'general.namespace' ) ),
	'oauth.host' => \DI\factory( function( string $api_host ) {
		return "{$api_host}/oauth/authorize";
	} )->parameter( 'api_host', \DI\get( 'api.host' ) ),
	AppServiceProviderInterface::class =>
		\DI\autowire( AppServiceProvider::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	ListingServiceProviderInterface::class =>
		\DI\autowire( ListingServiceProvider::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	ServiceServiceProviderInterface::class =>
		\DI\autowire( ServiceServiceProvider::class ),
	PostTypeServiceProviderInterface::class =>
		\DI\autowire( PostTypeServiceProvider::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) )
		->constructorParameter( 'text_domain', \DI\get( 'general.text_domain' ) ),
	RouteServiceProviderInterface::class => 
		\DI\autowire( RouteServiceProvider::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'logo', \DI\get( 'general.logo' ) )
		->constructorParameter( 'brand', \DI\get( 'general.brand' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	ShortcodeServiceProviderInterface::class =>
		\DI\autowire( ShortcodeServiceProvider::class )
		->constructorParameter(
			'namespace', \DI\get( 'general.namespace' )
		),
	TaxonomyServiceProviderInterface::class =>
		\DI\autowire( TaxonomyServiceProvider::class )
		->constructorParameter(
			'namespace', \DI\get( 'general.namespace' )
		)
		->constructorParameter(
			'root_dir', \DI\get( 'general.root_dir' )
		)
		->constructorParameter(
			'text_domain', \DI\get( 'general.text_domain' )
		),
	AuthApiControllerInterface::class =>
		\DI\autowire( AuthApiController::class ),
	CreditGroupApiControllerInterface::class =>
		\DI\autowire( CreditGroupApiController::class ),
	CreditTransactionApiControllerInterface::class    
		=> \DI\autowire( CreditTransactionApiController::class ),
	CreditVendorApiControllerInterface::class         
		=> \DI\autowire( CreditVendorApiController::class ),
	TokenAddressApiControllerInterface::class         
		=> \DI\autowire( TokenAddressApiController::class ),
	TokenPromiseApiControllerInterface::class         
		=> \DI\autowire( TokenPromiseApiController::class ),
	TokenSourceApiControllerInterface::class          
		=> \DI\autowire( TokenSourceApiController::class ),
	TokenVendorApiControllerInterface::class          
		=> \DI\autowire( TokenVendorApiController::class ),
	SettingsApiControllerInterface::class             
		=> \DI\autowire( SettingsApiController::class ),
	UserApiControllerInterface::class
		=> \DI\autowire( UserApiController::class )
			->constructorParameter(
				'namespace', \DI\get( 'general.namespace' )
			),
	CreditGroupAdminControllerInterface::class
		=> \DI\autowire( CreditGroupAdminController::class ),
	CreditTransactionAdminControllerInterface::class
		=> \DI\autowire( CreditTransactionAdminController::class ),
	CreditVendorAdminControllerInterface::class
		=> \DI\autowire( CreditVendorAdminController::class ),
	DashboardAdminControllerInterface::class
		=> \DI\autowire( DashboardAdminController::class ),
	PostAdminControllerInterface::class
		=> \DI\autowire( PostAdminController::class ),
	SettingsAdminControllerInterface::class
		=> \DI\autowire( SettingsAdminController::class ),
	TermAdminControllerInterface::class
		=> \DI\autowire( TermAdminController::class ),
	TokenAddressAdminControllerInterface::class
		=> \DI\autowire( TokenAddressAdminController::class ),
	TokenCategoryTermAdminControllerInterface::class
		=> \DI\autowire( TokenCategoryTermAdminController::class )
			->constructorParameter(
					'fallback_image', \DI\get( 'general.fallback_image' )
			),
	TokenMetaAdminControllerInterface::class
		=> \DI\autowire( TokenMetaAdminController::class ),
	TokenPromiseAdminControllerInterface::class
		=> \DI\autowire( TokenPromiseAdminController::class ),
	TokenSourceAdminControllerInterface::class
		=> \DI\autowire( TokenSourceAdminController::class ),
	TokenVendorAdminControllerInterface::class
		=> \DI\autowire( TokenVendorAdminController::class ),
	TokenWhitelistAdminControllerInterface::class
		=> \DI\autowire( TokenWhitelistAdminController::class ),
	UserAdminControllerInterface::class
		=> \DI\autowire( UserAdminController::class ),
	AuthControllerInterface::class
		=> \DI\autowire( AuthController::class )
			->constructorParameter(
				'namespace', \DI\get( 'general.namespace' )
			),
	UserControllerInterface::class
		=> \DI\autowire( UserController::class )
			->constructorParameter(
				'namespace', \DI\get( 'general.namespace' )
			),
	PostControllerInterface::class
		=> \DI\autowire( PostController::class ),
	AuthServiceInterface::class
		=> \DI\autowire( AuthService::class )
			->constructorParameter(
				'namespace', \DI\get( 'general.namespace' )
			)
			->constructorParameter(
				'oauth_callback_route', \DI\get('oauth.callback_route')
			)
			->constructorParameter(
				'api_host', \DI\get( 'api.host' )
			),
	LifecycleServiceInterface::class => \DI\autowire( LifecycleService::class )
		->constructorParameter(
			'root_filepath',
			\DI\get( 'general.root_filepath' )
		)
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) )
		->constructorParameter( 'version', \DI\get( 'general.version' ) ),
	ResourceServiceInterface::class =>
		\DI\autowire( ResourceService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) )
		->constructorParameter( 'root_url', \DI\get( 'general.root_url' ) )
		->constructorParameter(
			'fallback_image',
			\DI\get( 'general.fallback_image' )
		),
	QueryServiceInterface::class =>
		\DI\autowire( QueryService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	CreditVendorServiceInterface::class =>
		\DI\autowire( CreditVendorService::class ),
	TokenVendorServiceInterface::class =>
		\DI\autowire( TokenVendorService::class ),
	TokenAccessCheckerServiceInterface::class =>
		\DI\autowire( TokenAccessCheckerService::class ),
	TokenAccessMenuItemFilterServiceInterface::class =>
		\DI\autowire( TokenAccessMenuItemFilterService::class ),
	TokenAccessPostGuardServiceInterface::class =>
		\DI\autowire( TokenAccessPostGuardService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TokenAccessPostResultsFilterServiceInterface::class  =>
		\DI\autowire( TokenAccessPostResultsFilterService::class )	
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TokenAccessPostCheckerServiceInterface::class =>
		\DI\autowire( TokenAccessPostCheckerService::class ),
	TokenAccessTermCheckerServiceInterface::class =>
		\DI\autowire( TokenAccessTermCheckerService::class ),
	TokenAccessTermGuardServiceInterface::class =>
		\DI\autowire( TokenAccessTermGuardService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	RouterInterface::class =>
		\DI\autowire( Router::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	AdminRouterInterface::class =>
		\DI\autowire( AdminRouter::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	ApiRouterInterface::class =>
		\DI\autowire( ApiRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	PostRouterInterface::class =>
		\DI\autowire( PostRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) )
		->constructorParameter( 'brand', \DI\get( 'general.brand' ) ),
	TermRouterInterface::class =>
		\DI\autowire( TermRouter::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'brand', \DI\get( 'general.brand' ) ),
	WebRouterInterface::class =>
		\DI\autowire( WebRouter::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	PostColumnRouterInterface::class =>
		\DI\autowire( PostColumnRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	UserColumnRouterInterface::class =>
		\DI\autowire( UserColumnRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	AssetNameFormatterServiceInterface::class =>
		\DI\autowire( AssetNameFormatterService::class ),
	QuantityCalculatorServiceInterface::class =>
		\DI\autowire( QuantityCalculatorService::class ),
	CreditAccountRepositoryInterface::class =>
		\DI\autowire( CreditAccountRepository::class ),
	CreditGroupRepositoryInterface::class =>
		\DI\autowire( CreditGroupRepository::class ),
	CreditGroupWhitelistRepositoryInterface::class =>
		\DI\autowire( CreditGroupWhitelistRepository::class ),
	CreditTransactionRepositoryInterface::class =>
		\DI\autowire( CreditTransactionRepository::class ),
	TermRepositoryInterface::class =>
		\DI\autowire( TermRepository::class ),
	TokenPromiseMetaRepositoryInterface::class =>
		\DI\autowire( TokenPromiseMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TokenMetaRepositoryInterface::class =>
		\DI\autowire( TokenMetaRepository::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	TokenPromiseRepositoryInterface::class =>
		\DI\autowire( TokenPromiseRepository::class ),
	TokenSourceRepositoryInterface::class =>
		\DI\autowire( TokenSourceRepository::class ),
	TokenAddressRepositoryInterface::class =>
		\DI\autowire( TokenAddressRepository::class ),
	TokenBalanceRepositoryInterface::class =>
		\DI\autowire( TokenBalanceRepository::class ),
	TokenCategoryTermRepositoryInterface::class =>
		\DI\autowire( TokenCategoryTermRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TokenWhitelistRepositoryInterface::class =>
		\DI\autowire( TokenWhitelistRepository::class ),
	OauthUserRepositoryInterface::class =>
		\DI\autowire( OauthUserRepository::class ),
	UserRepositoryInterface::class =>
		\DI\autowire( UserRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	PostRepositoryInterface::class =>
		\DI\autowire( PostRepository::class ),
	PostMetaRepositoryInterface::class =>
		\DI\autowire( PostMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TermMetaRepositoryInterface::class =>
		\DI\autowire( TermMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	UserMetaRepositoryInterface::class =>
		\DI\autowire( UserMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	OptionRepositoryInterface::class =>
		\DI\autowire( OptionRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	OauthSettingsRepositoryInterface::class =>
		\DI\autowire( OauthSettingsRepository::class ),
	IntegrationSettingsRepositoryInterface::class =>
		\DI\autowire( IntegrationSettingsRepository::class ),
	TcaSettingsRepositoryInterface::class =>
		\DI\autowire( TcaSettingsRepository::class ),
	AdminRouteRepositoryInterface::class =>
		\DI\autowire( AdminRouteRepository::class ),
	ApiRouteRepositoryInterface::class =>
		\DI\autowire( ApiRouteRepository::class ),
	PostRouteRepositoryInterface::class =>
		\DI\autowire( PostRouteRepository::class ),
	TermRouteRepositoryInterface::class =>
		\DI\autowire( TermRouteRepository::class ),
	WebRouteRepositoryInterface::class =>
		\DI\autowire( WebRouteRepository::class ),
	DashboardPolicyInterface::class =>
		\DI\autowire( DashboardPolicy::class ),
	PostPolicyInterface::class =>
		\DI\autowire( PostPolicy::class ),
	SettingsPolicyInterface::class =>
		\DI\autowire( SettingsPolicy::class ),
	TermPolicyInterface::class =>
		\DI\autowire( TermPolicy::class ),
	UserPolicyInterface::class =>
		\DI\autowire( UserPolicy::class ),
	TokenAddressPolicyInterface::class =>
		\DI\autowire( TokenAddressPolicy::class ),
	TokenCategoryTermPolicyInterface::class =>
		\DI\autowire( TokenCategoryTermPolicy::class ),
	TokenMetaPolicyInterface::class =>
		\DI\autowire( TokenMetaPolicy::class ),
	TokenPromisePolicyInterface::class =>
		\DI\autowire( TokenPromisePolicy::class ),
	TokenSourcePolicyInterface::class =>
		\DI\autowire( TokenSourcePolicy::class ),
	TokenVendorPolicyInterface::class =>
		\DI\autowire( TokenVendorPolicy::class ),
	TokenWhitelistPolicyInterface::class =>
		\DI\autowire( TokenWhitelistPolicy::class ),
	CreditGroupPolicyInterface::class =>
		\DI\autowire( CreditGroupPolicy::class ),
	CreditTransactionPolicyInterface::class =>
		\DI\autowire( CreditTransactionPolicy::class ),
	CreditVendorPolicyInterface::class =>
		\DI\autowire( CreditVendorPolicy::class ),
	CreditItemCardListBlockModelInterface::class =>
		\DI\autowire( CreditItemCardListBlockModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'admin_page_url', DI\get( 'admin.page_url' ) ),
	TokenItemCardListBlockModelInterface::class =>
		\DI\autowire( TokenItemCardListBlockModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'admin_page_url', DI\get( 'admin.page_url' ) ),
	UserInfoBlockModelInterface::class =>
		\DI\autowire( UserInfoBlockModel::class ),
	LoginButtonComponentModelInterface::class =>
		\DI\autowire( LoginButtonComponentModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	LogoutButtonComponentModelInterface::class =>
		\DI\autowire( LogoutButtonComponentModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 'root_dir', \DI\get( 'general.root_dir' ) ),
	CreditItemCardComponentModelInterface::class =>
		\DI\autowire( CreditItemCardComponentModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TokenItemCardComponentModelInterface::class =>
		\DI\autowire( TokenItemCardComponentModel::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) )
		->constructorParameter( 
			'fallback_image', 
			\DI\get( 'general.fallback_image' ) 
		),
	TokenMetaFeaturedImageColumnInterface::class =>
		\DI\autowire( TokenMetaFeaturedImageColumn::class )
		->constructorParameter( 'root_url', \DI\get( 'general.root_url' ) ),
	UserCreditBalanceColumnInterface::class =>
		\DI\autowire( UserCreditBalanceColumn::class ),
	CreditGroupStoreViewModelInterface::class =>
		\DI\autowire( CreditGroupStoreViewModel::class ),
	CreditGroupWhitelistEditViewModelInterface::class =>
		\DI\autowire( CreditGroupWhitelistEditViewModel::class ),
	DashboardViewModelInterface::class =>
		\DI\autowire( DashboardViewModel::class ),
	PostEditViewModelInterface::class =>
		\DI\autowire( PostEditViewModel::class ),
	TermEditViewModelInterface::class =>
		\DI\autowire( TermEditViewModel::class ),
	SettingsViewModelInterface::class =>
		\DI\autowire( SettingsViewModel::class )
		->constructorParameter(
			'oauth_callback_route',
			\DI\get( 'oauth.callback_route' )
		),
	TokenMetaEditViewModelInterface::class =>
		\DI\autowire( TokenMetaEditViewModel::class ),
	TokenCategoryTermEditViewModelInterface::class =>
		\DI\autowire( TokenCategoryTermEditViewModel::class ),
	TokenWhitelistEditViewModelInterface::class =>
		\DI\autowire( TokenWhitelistEditViewModel::class ),
	PostAccessDeniedViewModelInterface::class =>
		\DI\autowire( PostAccessDeniedViewModel::class ),
	UserViewModelInterface::class =>
		\DI\autowire( UserViewModel::class ),
	LoginButtonShortcodeInterface::class =>
		\DI\autowire( LoginButtonShortcode::class ),
	LogoutButtonShortcodeInterface::class =>
		\DI\autowire( LogoutButtonShortcode::class ),
	InventoryShortcodeInterface::class =>
		\DI\autowire( InventoryShortcode::class ),
	UserInfoShortcodeInterface::class =>
		\DI\autowire( UserInfoShortcode::class ),
	CreditBalanceShortcodeInterface::class =>
		\DI\autowire( CreditBalanceShortcode::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	CreditInventoryShortcodeInterface::class =>
		\DI\autowire( CreditInventoryShortcode::class ),
	TokenBalanceShortcodeInterface::class =>
		\DI\autowire( TokenBalanceShortcode::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	TokenInventoryShortcodeInterface::class =>
		\DI\autowire( TokenInventoryShortcode::class ),
	TokenMetaShortcodeInterface::class =>
		\DI\autowire( TokenMetaShortcode::class ),
	TokenMetaInfoShortcodeInterface::class =>
		\DI\autowire( TokenMetaInfoShortcode::class )
		->constructorParameter(
			'fallback_image',
			DI\get( 'general.fallback_image' )
		),
	TokenMetaAttributesShortcodeInterface::class =>
		\DI\autowire( TokenMetaAttributesShortcode::class ),
	TokenMetaMediaShortcodeInterface::class =>
		\DI\autowire( TokenMetaMediaShortcode::class ),
	TokenpassAPI::class => \DI\factory(
		function ( 
			ContainerInterface $container,
			IntegrationSettingsRepositoryInterface $integration_settings_repository,
			string $api_host,
			string $oauth_callback_route
		) {
			$settings = $integration_settings_repository->show();
			$client_id = $settings->client_id;
			$client_secret = $settings->client_secret;
			$privileged_client_id = $client_id;
			$privileged_client_secret = $client_secret;
			$oauth_client_id = $client_id;
			$oauth_client_secret = $client_secret;
			$tokenpass_url = $api_host;
			$redirect_uri = $oauth_callback_route;
			$ssl = is_ssl();
			return new TokenpassAPI(
				$client_id,
				$client_secret,
				$privileged_client_id,
				$privileged_client_secret,
				$tokenpass_url,
				$redirect_uri,
				$oauth_client_id,
				$oauth_client_secret,
				$ssl,
			);
		} )
		->parameter( 'api_host', \DI\get( 'api.host' ) )
		->parameter(
			'oauth_callback_route',
			\DI\get( 'oauth.callback_route' )
		),
	TokenpassAPIInterface::class => \DI\get( TokenpassAPI::class ),
	Environment::class => \DI\factory( function (
		string $twig_template_dir,
		string $twig_template_cache_dir
	) {
		$loader = new FilesystemLoader( $twig_template_dir );
		$twig = new Environment( $loader, array(
			'cache' => false,
		) );
		$twig->registerUndefinedFunctionCallback(function( $name ) {
			if ( function_exists( $name ) ) {
				return new \Twig\TwigFunction(
					$name,
					function() use ( $name ) {
						return call_user_func_array( $name, func_get_args() );
					}
				);
			}
			throw new \RuntimeException(
				sprintf( 'Function %s not found', $name )
			);
		});
		return $twig;
	} )
		->parameter(
			'twig_template_dir',
			\DI\get( 'twig.template_dir' )
		)
		->parameter(
			'twig_template_cache_dir',
			\DI\get( 'twig.template_cache_dir' )
		),
);
