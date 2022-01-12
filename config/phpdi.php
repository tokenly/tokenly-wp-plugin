<?php

use Psr\Container\ContainerInterface;
use Tokenly\Wp\Providers\AppServiceProvider;
use Tokenly\Wp\Providers\RouteServiceProvider;
use Tokenly\Wp\Providers\ShortcodeServiceProvider;
use Tokenly\Wp\Services\AuthService;
use Tokenly\Wp\Services\LifecycleService;
use Tokenly\Wp\Services\ResourceService;
use Tokenly\Wp\Services\QueryService;
use Tokenly\Wp\Services\Domain\OauthUserService;
use Tokenly\Wp\Services\Domain\PostService;
use Tokenly\Wp\Services\Domain\TermService;
use Tokenly\Wp\Services\Domain\UserService;
use Tokenly\Wp\Services\Domain\Token\AddressService as TokenAddressService;
use Tokenly\Wp\Services\Domain\Token\BalanceService as TokenBalanceService;
use Tokenly\Wp\Services\Domain\Token\PromiseMetaService as TokenPromiseMetaService;
use Tokenly\Wp\Services\Domain\Token\PromiseService as TokenPromiseService;
use Tokenly\Wp\Services\Domain\Token\SourceService as TokenSourceService;
use Tokenly\Wp\Services\Domain\Token\MetaService as TokenMetaService;
use Tokenly\Wp\Services\Domain\Credit\AccountService as CreditAccountService;
use Tokenly\Wp\Services\Domain\Credit\GroupService as CreditGroupService;
use Tokenly\Wp\Services\Domain\Credit\TransactionService as CreditTransactionService;
use Tokenly\Wp\Repositories\OauthUserRepository;
use Tokenly\Wp\Repositories\PostRepository;
use Tokenly\Wp\Repositories\TermRepository;
use Tokenly\Wp\Repositories\UserRepository;
use Tokenly\Wp\Repositories\Credit\AccountRepository as CreditAccountRepository;
use Tokenly\Wp\Repositories\Credit\GroupRepository as CreditGroupRepository;
use Tokenly\Wp\Repositories\Credit\TransactionRepository as CreditTransactionRepository;
use Tokenly\Wp\Repositories\General\PostMetaRepository;
use Tokenly\Wp\Repositories\General\OptionRepository;
use Tokenly\Wp\Repositories\General\TermMetaRepository;
use Tokenly\Wp\Repositories\General\UserMetaRepository;
use Tokenly\Wp\Repositories\Token\AddressRepository as TokenAddressRepository;
use Tokenly\Wp\Repositories\Token\BalanceRepository as TokenBalanceRepository;
use Tokenly\Wp\Repositories\Token\PromiseRepository as TokenPromiseRepository;
use Tokenly\Wp\Repositories\Token\PromiseMetaRepository as TokenPromiseMetaRepository;
use Tokenly\Wp\Repositories\Token\SourceRepository as TokenSourceRepository;
use Tokenly\Wp\Repositories\Token\MetaRepository as TokenMetaRepository;
use Tokenly\Wp\Routes\AdminRouter;
use Tokenly\Wp\Routes\ApiRouter;
use Tokenly\Wp\Routes\PostTypeRouter;
use Tokenly\Wp\Routes\TaxonomyRouter;
use Tokenly\Wp\Routes\WebRouter;
use Tokenly\Wp\Controllers\Web\AuthController;
use Tokenly\Wp\Controllers\Web\PostController;
use Tokenly\Wp\Controllers\Web\TermController;
use Tokenly\Wp\Controllers\Web\TokenMetaController;
use Tokenly\Wp\Controllers\Web\UserController;
use Tokenly\Wp\Controllers\Web\Admin\ConnectionController as ConnectionAdminController;
use Tokenly\Wp\Controllers\Web\Admin\DashboardController as DashboardAdminController;
use Tokenly\Wp\Controllers\Web\Admin\SettingsController as SettingsAdminController;
use Tokenly\Wp\Controllers\Web\Admin\UserController as UserAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Credit\GroupController as CreditGroupAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Credit\TransactionController as CreditTransactionAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Credit\VendorController as CreditVendorAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Token\AddressController as TokenAddressAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Token\SourceController as TokenSourceAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Token\VendorController as TokenVendorAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Token\PromiseController as TokenPromiseAdminController;
use Tokenly\Wp\Controllers\Web\Admin\Token\WhitelistController as TokenWhitelistAdminController;
use Tokenly\Wp\Controllers\Api\AuthController as AuthApiController;
use Tokenly\Wp\Controllers\Api\SettingsController as SettingsApiController;
use Tokenly\Wp\Controllers\Api\UserController as UserApiController;
use Tokenly\Wp\Controllers\Api\Credit\GroupController as CreditGroupApiController;
use Tokenly\Wp\Controllers\Api\Credit\TransactionController as CreditTransactionApiController;
use Tokenly\Wp\Controllers\Api\Token\AddressController as TokenAddressApiController;
use Tokenly\Wp\Controllers\Api\Token\BalanceController as TokenBalanceApiController;
use Tokenly\Wp\Controllers\Api\Token\PromiseController as TokenPromiseApiController;
use Tokenly\Wp\Controllers\Api\Token\SourceController as TokenSourceApiController;
use Tokenly\Wp\Controllers\Api\Token\WhitelistController as TokenWhitelistApiController;
use Tokenly\Wp\Controllers\Api\User\Credit\BalanceController as UserCreditBalanceApiController;
use Tokenly\Wp\Controllers\Api\User\Token\BalanceController as UserTokenBalanceApiController;
use Tokenly\Wp\Collections\Collection;
use Tokenly\Wp\Collections\PostCollection;
use Tokenly\Wp\Collections\TermCollection;
use Tokenly\Wp\Collections\UserCollection;
use Tokenly\Wp\Collections\WhitelistItemCollection;
use Tokenly\Wp\Collections\Tca\RuleCollection as TcaRuleCollection;
use Tokenly\Wp\Collections\Tca\RuleCheckResultCollection as TcaRuleCheckResultCollection;
use Tokenly\Wp\Collections\Token\AddressCollection as TokenAddressCollection;
use Tokenly\Wp\Collections\Token\BalanceCollection as TokenBalanceCollection;
use Tokenly\Wp\Collections\Token\PromiseCollection as TokenPromiseCollection;
use Tokenly\Wp\Collections\Token\PromiseMetaCollection as TokenPromiseMetaCollection;
use Tokenly\Wp\Collections\Token\SourceCollection as TokenSourceCollection;
use Tokenly\Wp\Collections\Token\MetaCollection as TokenMetaCollection;
use Tokenly\Wp\Collections\Credit\AccountCollection as CreditAccountCollection;
use Tokenly\Wp\Collections\Credit\GroupCollection as CreditGroupCollection;
use Tokenly\Wp\Collections\Credit\TransactionCollection as CreditTransactionCollection;
use Tokenly\Wp\Models\OauthUser;
use Tokenly\Wp\Models\Post;
use Tokenly\Wp\Models\Integration;
use Tokenly\Wp\Models\Term;
use Tokenly\Wp\Models\User;
use Tokenly\Wp\Models\Token\Address as TokenAddress;
use Tokenly\Wp\Models\Token\Balance as TokenBalance;
use Tokenly\Wp\Models\Credit\Account as CreditAccount;
use Tokenly\Wp\Models\Credit\Group as CreditGroup;
use Tokenly\Wp\Models\Credit\Transaction as CreditTransaction;
use Tokenly\Wp\Models\Tca\RuleCheckResult as TcaRuleCheckResult;
use Tokenly\Wp\Models\Tca\AccessVerdict as TcaAccessVerdict;
use Tokenly\Wp\Models\Tca\Rule as TcaRule;
use Tokenly\Wp\Models\Token\Promise as TokenPromise;
use Tokenly\Wp\Models\Token\PromiseMeta as TokenPromiseMeta;
use Tokenly\Wp\Models\Token\Quantity as TokenQuantity;
use Tokenly\Wp\Models\Token\Source as TokenSource;
use Tokenly\Wp\Models\Token\Meta as TokenMeta;
use Tokenly\Wp\Models\Settings\OauthSettings;
use Tokenly\Wp\Models\Settings\IntegrationSettings;
use Tokenly\Wp\Models\Settings\TcaSettings;
use Tokenly\Wp\Models\Settings\WhitelistSettings;
use Tokenly\Wp\Models\Settings\WhitelistItem;
use Tokenly\Wp\Middleware\Tca\MenuItemFilterMiddleware as TcaMenuItemFilterMiddleware;
use Tokenly\Wp\Middleware\Tca\PostGuardMiddleware as TcaPostGuardMiddleware;
use Tokenly\Wp\Middleware\Tca\PostResultsFilterMiddleware as TcaPostResultsFilterMiddleware;
use Tokenly\Wp\Presentation\Blocks\AppCreditItemCardListBlockModel;
use Tokenly\Wp\Presentation\Blocks\TokenItemCardListBlockModel;
use Tokenly\Wp\Presentation\Blocks\UserInfoBlockModel;
use Tokenly\Wp\Presentation\Components\AppCreditItemCardComponentModel;
use Tokenly\Wp\Presentation\Components\LoginButtonComponentModel;
use Tokenly\Wp\Presentation\Components\LogoutButtonComponentModel;
use Tokenly\Wp\Presentation\Components\TokenItemCardComponentModel;
use Tokenly\Wp\Presentation\Views\Admin\DashboardViewModel;
use Tokenly\Wp\Presentation\Views\Admin\PostEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\SettingsViewModel;
use Tokenly\Wp\Presentation\Views\Admin\TermEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\TokenMetaEditViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Credit\GroupStoreViewModel as CreditGroupStoreViewModel;
use Tokenly\Wp\Presentation\Views\Admin\Token\WhitelistEditViewModel as TokenWhitelistEditViewModel;
use Tokenly\Wp\Presentation\Views\Web\PostAccessDeniedViewModel;
use Tokenly\Wp\Presentation\Views\Web\UserViewModel;
use Tokenly\Wp\Presentation\Shortcodes\CreditInventoryShortcode;
use Tokenly\Wp\Presentation\Shortcodes\LogoutButtonShortcode;
use Tokenly\Wp\Presentation\Shortcodes\LoginButtonShortcode;
use Tokenly\Wp\Presentation\Shortcodes\TokenInventoryShortcode;
use Tokenly\Wp\Presentation\Shortcodes\UserInfoShortcode;
use Tokenly\Wp\Interfaces\Providers\AppServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\RouteServiceProviderInterface;
use Tokenly\Wp\Interfaces\Providers\ShortcodeServiceProviderInterface;
use Tokenly\Wp\Interfaces\Services\AuthServiceInterface;
use Tokenly\Wp\Interfaces\Services\LifecycleServiceInterface;
use Tokenly\Wp\Interfaces\Services\ResourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\QueryServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\OauthUserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\PostServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\TermServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\UserServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\AccountServiceInterface as CreditAccountServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\GroupServiceInterface as CreditGroupServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Credit\TransactionServiceInterface as CreditTransactionServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\AddressServiceInterface as TokenAddressServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\BalanceServiceInterface as TokenBalanceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseMetaServiceInterface as TokenPromiseMetaServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\PromiseServiceInterface as TokenPromiseServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\SourceServiceInterface as TokenSourceServiceInterface;
use Tokenly\Wp\Interfaces\Services\Domain\Token\MetaServiceInterface as TokenMetaServiceInterface;
use Tokenly\Wp\Interfaces\Repositories\OauthUserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\PostRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\TermRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\UserRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\AccountRepositoryInterface as CreditAccountRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\GroupRepositoryInterface as CreditGroupRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Credit\TransactionRepositoryInterface as CreditTransactionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\AddressRepositoryInterface as TokenAddressRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\BalanceRepositoryInterface as TokenBalanceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseRepositoryInterface as TokenPromiseRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\SourceRepositoryInterface as TokenSourceRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\PromiseMetaRepositoryInterface as TokenPromiseMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\Token\MetaRepositoryInterface as TokenMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\PostMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\TermMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\OptionRepositoryInterface;
use Tokenly\Wp\Interfaces\Repositories\General\UserMetaRepositoryInterface;
use Tokenly\Wp\Interfaces\Routes\AdminRouterInterface;
use Tokenly\Wp\Interfaces\Routes\ApiRouterInterface;
use Tokenly\Wp\Interfaces\Routes\PostTypeRouterInterface;
use Tokenly\Wp\Interfaces\Routes\TaxonomyRouterInterface;
use Tokenly\Wp\Interfaces\Routes\WebRouterInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\AuthControllerInterface as AuthApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\SettingsControllerInterface as SettingsApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\UserControllerInterface as UserApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\GroupControllerInterface as CreditGroupApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Credit\TransactionControllerInterface as CreditTransactionApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\AddressControllerInterface as TokenAddressApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\PromiseControllerInterface as TokenPromiseApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Api\Token\SourceControllerInterface as TokenSourceApiControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\AuthControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\PostControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TermControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\TokenMetaControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\UserControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\DashboardControllerInterface as DashboardAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\SettingsControllerInterface as SettingsAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\ConnectionControllerInterface as ConnectionAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\UserControllerInterface as UserAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\GroupControllerInterface as CreditGroupAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\TransactionControllerInterface as CreditTransactionAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Credit\VendorControllerInterface as CreditVendorAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\AddressControllerInterface as TokenAddressAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\PromiseControllerInterface as TokenPromiseAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\SourceControllerInterface as TokenSourceAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\VendorControllerInterface as TokenVendorAdminControllerInterface;
use Tokenly\Wp\Interfaces\Controllers\Web\Admin\Token\WhitelistControllerInterface as TokenWhitelistAdminControllerInterface;
use Tokenly\Wp\Interfaces\Factories\Models\TermFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\UserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\OauthUserFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\PostFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\WhitelistItemFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\AccountFactoryInterface as CreditAccountFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\AccountHistoryFactoryInterface as CreditAccountHistoryFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\GroupFactoryInterface as CreditGroupFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\GroupHistoryFactoryInterface as CreditGroupHistoryFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Credit\TransactionFactoryInterface as CreditTransactionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Tca\AccessVerdictFactoryInterface as TcaAccessVerdictFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Tca\RuleFactoryInterface as TcaRuleFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Tca\RuleCheckResultFactoryInterface as TcaRuleCheckResultFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\AddressFactoryInterface as TokenAddressFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\BalanceFactoryInterface as TokenBalanceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\MetaFactoryInterface as TokenMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\PromiseFactoryInterface as TokenPromiseFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\PromiseMetaFactoryInterface as TokenPromiseMetaFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\QuantityFactoryInterface as TokenQuantityFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Models\Token\SourceFactoryInterface as TokenSourceFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\PostCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\TermCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\UserCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\WhitelistItemCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Credit\AccountCollectionFactoryInterface as CreditAccountCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Credit\GroupCollectionFactoryInterface as CreditGroupCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Credit\TransactionCollectionFactoryInterface as CreditTransactionCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Tca\RuleCheckResultCollectionFactoryInterface as TcaRuleCheckResultCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Tca\RuleCollectionFactoryInterface as TcaRuleCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\AddressCollectionFactoryInterface as TokenAddressCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\BalanceCollectionFactoryInterface as TokenBalanceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\PromiseCollectionFactoryInterface as TokenPromiseCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\PromiseMetaCollectionFactoryInterface as TokenPromiseMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\SourceCollectionFactoryInterface as TokenSourceCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Factories\Collections\Token\MetaCollectionFactoryInterface as TokenMetaCollectionFactoryInterface;
use Tokenly\Wp\Interfaces\Collections\CollectionInterface;
use Tokenly\Wp\Interfaces\Collections\PostCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\TermCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\UserCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\WhitelistItemCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\AccountCollectionInterface as CreditAccountCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\GroupCollectionInterface as CreditGroupCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface as CreditTransactionCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Tca\RuleCheckResultCollectionInterface as TcaRuleCheckResultCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Tca\RuleCollectionInterface as TcaRuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\AddressCollectionInterface as TokenAddressCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\BalanceCollectionInterface as TokenBalanceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseCollectionInterface as TokenPromiseCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\PromiseMetaCollectionInterface as TokenPromiseMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\SourceCollectionInterface as TokenSourceCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\MetaCollectionInterface as TokenMetaCollectionInterface;
use Tokenly\Wp\Interfaces\Models\PostInterface;
use Tokenly\Wp\Interfaces\Models\IntegrationInterface;
use Tokenly\Wp\Interfaces\Models\TermInterface;
use Tokenly\Wp\Interfaces\Models\UserInterface;
use Tokenly\Wp\Interfaces\Models\Token\AddressInterface as TokenAddressInterface;
use Tokenly\Wp\Interfaces\Models\Token\BalanceInterface as TokenBalanceInterface;
use Tokenly\Wp\Interfaces\Models\Credit\AccountInterface as CreditAccountInterface;
use Tokenly\Wp\Interfaces\Models\Credit\AccountHistoryInterface as CreditAccountHistoryInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupInterface as CreditGroupInterface;
use Tokenly\Wp\Interfaces\Models\Credit\GroupHistoryInterface as CreditGroupHistoryInterface;
use Tokenly\Wp\Interfaces\Models\Credit\TransactionInterface as CreditTransactionInterface;
use Tokenly\Wp\Interfaces\Models\Credit\WalletInterface as CreditWalletInterface;
use Tokenly\Wp\Interfaces\Models\Settings\OauthSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\IntegrationSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\TcaSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistSettingsInterface;
use Tokenly\Wp\Interfaces\Models\Settings\WhitelistItemInterface;
use Tokenly\Wp\Interfaces\Models\Tca\RuleCheckResultInterface as TcaRuleCheckResultInterface;
use Tokenly\Wp\Interfaces\Models\Tca\AccessVerdictInterface as TcaAccessVerdictInterface;
use Tokenly\Wp\Interfaces\Models\Tca\RuleInterface as TcaRuleInterface;
use Tokenly\Wp\Interfaces\Models\Tca\GuardInterface as TcaGuardInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseInterface as TokenPromiseInterface;
use Tokenly\Wp\Interfaces\Models\Token\PromiseMetaInterface as TokenPromiseMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\SourceInterface as TokenSourceInterface;
use Tokenly\Wp\Interfaces\Models\Token\MetaInterface as TokenMetaInterface;
use Tokenly\Wp\Interfaces\Models\Token\QuantityInterface as TokenQuantityInterface;
use Tokenly\Wp\Interfaces\Models\Token\WalletInterface as TokenWalletInterface;
use Tokenly\Wp\Interfaces\Middleware\Tca\MenuItemFilterMiddlewareInterface as TcaMenuItemFilterMiddlewareInterface;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostGuardMiddlewareInterface as TcaPostGuardMiddlewareInterface;
use Tokenly\Wp\Interfaces\Middleware\Tca\PostResultsFilterMiddlewareInterface as TcaPostResultsFilterMiddlewareInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\CreditInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LoginButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\LogoutButtonShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\TokenInventoryShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Shortcodes\UserInfoShortcodeInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\AppCreditItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\TokenItemCardListBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Blocks\UserInfoBlockModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\AppCreditItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LoginButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\LogoutButtonComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Components\TokenItemCardComponentModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\DashboardViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\PostEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\SettingsViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TermEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\TokenMetaEditViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Credit\GroupStoreViewModelInterface as CreditGroupStoreViewModelInterface;
use Tokenly\Wp\Interfaces\Presentation\Views\Admin\Token\WhitelistEditViewModelInterface as TokenWhitelistEditViewModelInterface;
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
	TokenAddressApiControllerInterface::class         => \DI\autowire( TokenAddressApiController::class ),
	TokenPromiseApiControllerInterface::class         => \DI\autowire( TokenPromiseApiController::class ),
	TokenSourceApiControllerInterface::class          => \DI\autowire( TokenSourceApiController::class ),
	SettingsApiControllerInterface::class             => \DI\autowire( SettingsApiController::class ),
	UserApiControllerInterface::class                 => \DI\autowire( UserApiController::class ),
	//Controllers - Admin
	CreditGroupAdminControllerInterface::class        => \DI\autowire( CreditGroupAdminController::class ),
	CreditTransactionAdminControllerInterface::class  => \DI\autowire( CreditTransactionAdminController::class ),
	CreditVendorAdminControllerInterface::class       => \DI\autowire( CreditVendorAdminController::class ),
	ConnectionAdminControllerInterface::class         => \DI\autowire( ConnectionAdminController::class ),
	DashboardAdminControllerInterface::class          => \DI\autowire( DashboardAdminController::class ),
	SettingsAdminControllerInterface::class           => \DI\autowire( SettingsAdminController::class ),
	UserAdminControllerInterface::class               => \DI\autowire( UserAdminController::class ),
	TokenAddressAdminControllerInterface::class       => \DI\autowire( TokenAddressAdminController::class ),
	TokenPromiseAdminControllerInterface::class       => \DI\autowire( TokenPromiseAdminController::class ),
	TokenSourceAdminControllerInterface::class        => \DI\autowire( TokenSourceAdminController::class ),
	TokenVendorAdminControllerInterface::class        => \DI\autowire( TokenVendorAdminController::class ),
	TokenWhitelistAdminControllerInterface::class     => \DI\autowire( TokenWhitelistAdminController::class ),
	//Controllers - Web
	AuthControllerInterface::class                 => \DI\autowire( AuthController::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	PostControllerInterface::class                 => \DI\autowire( PostController::class ),
	TermControllerInterface::class                 => \DI\autowire( TermController::class ),
	TokenMetaControllerInterface::class            => \DI\autowire( TokenMetaController::class ),
	UserControllerInterface::class                 => \DI\autowire( UserController::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
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
	CreditAccountServiceInterface::class           => \DI\autowire( CreditAccountService::class ),
	CreditGroupServiceInterface::class             => \DI\autowire( CreditGroupService::class ),
	CreditTransactionServiceInterface::class       => \DI\autowire( CreditTransactionService::class ),
	OauthUserServiceInterface::class               => \DI\autowire( OauthUserService::class ),
	PostServiceInterface::class                    => \DI\autowire( PostService::class ),
	TermServiceInterface::class                    => \DI\autowire( TermService::class ),
	TokenPromiseMetaServiceInterface::class        => \DI\autowire( TokenPromiseMetaService::class ),
	TokenPromiseServiceInterface::class            => \DI\autowire( TokenPromiseService::class ),
	TokenSourceServiceInterface::class             => \DI\autowire( TokenSourceService::class ),
	TokenAddressServiceInterface::class            => \DI\autowire( TokenAddressService::class ),
	TokenBalanceServiceInterface::class            => \DI\autowire( TokenBalanceService::class ),
	TokenMetaServiceInterface::class               => \DI\autowire( TokenMetaService::class ),
	UserServiceInterface::class                    => \DI\autowire( UserService::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Repositories - General
	PostMetaRepositoryInterface::class             => \DI\autowire( PostMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TermMetaRepositoryInterface::class             => \DI\autowire( TermMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	UserMetaRepositoryInterface::class             => \DI\autowire( UserMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	OptionRepositoryInterface::class               => \DI\autowire( OptionRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	//Repositories - Domain
	CreditAccountRepositoryInterface::class        => \DI\autowire( CreditAccountRepository::class ),
	CreditGroupRepositoryInterface::class          => \DI\autowire( CreditGroupRepository::class ),
	CreditTransactionRepositoryInterface::class    => \DI\autowire( CreditTransactionRepository::class ),
	TermRepositoryInterface::class                 => \DI\autowire( TermRepository::class ),
	TokenPromiseMetaRepositoryInterface::class     => \DI\autowire( TokenPromiseMetaRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TokenMetaRepositoryInterface::class            => \DI\autowire( TokenMetaRepository::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	TokenPromiseRepositoryInterface::class         => \DI\autowire( TokenPromiseRepository::class ),
	TokenSourceRepositoryInterface::class          => \DI\autowire( TokenSourceRepository::class ),
	TokenAddressRepositoryInterface::class         => \DI\autowire( TokenAddressRepository::class ),
	TokenBalanceRepositoryInterface::class         => \DI\autowire( TokenBalanceRepository::class ),
	OauthUserRepositoryInterface::class            => \DI\autowire( OauthUserRepository::class ),
	UserRepositoryInterface::class                 => \DI\autowire( UserRepository::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	PostRepositoryInterface::class                 => \DI\autowire( PostRepository::class ),
	//Routes
	AdminRouterInterface::class                    => \DI\autowire( AdminRouter::class )
		->constructorParameter( 'root_dir', DI\get( 'general.root_dir' ) )
		->constructorParameter( 'api_host', DI\get( 'api.host' ) )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	ApiRouterInterface::class                      => \DI\autowire( ApiRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	PostTypeRouterInterface::class                 => \DI\autowire( PostTypeRouter::class )
		->constructorParameter( 'namespace', DI\get( 'general.namespace' ) ),
	TaxonomyRouterInterface::class                 => \DI\autowire( TaxonomyRouter::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
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
	CreditGroupStoreViewModelInterface::class        => \DI\autowire( CreditGroupStoreViewModel::class ),
	DashboardViewModelInterface::class               => \DI\autowire( DashboardViewModel::class ),
	PostEditViewModelInterface::class                => \DI\autowire( PostEditViewModel::class ),
	SettingsViewModelInterface::class                => \DI\autowire( SettingsViewModel::class )
		->constructorParameter( 'oauth_callback_route', \DI\get( 'oauth.callback_route' ) ),
	TermEditViewModelInterface::class                => \DI\autowire( TermEditViewModel::class ),
	TokenMetaEditViewModelInterface::class           => \DI\autowire( TokenMetaEditViewModel::class ),
	TokenWhitelistEditViewModelInterface::class      => \DI\autowire( TokenWhitelistEditViewModel::class ),
	//Presentation - View models - Web
	PostAccessDeniedViewModelInterface::class        => \DI\autowire( PostAccessDeniedViewModel::class ),
	UserViewModelInterface::class                    => \DI\autowire( UserViewModel::class ),
	//Presentation - Shortcodes
	CreditInventoryShortcodeInterface::class         => \DI\autowire( CreditInventoryShortcode::class ),
	LoginButtonShortcodeInterface::class             => \DI\autowire( LoginButtonShortcode::class ),
	LogoutButtonShortcodeInterface::class            => \DI\autowire( LogoutButtonShortcode::class ),
	TokenInventoryShortcodeInterface::class          => \DI\autowire( TokenInventoryShortcode::class ),
	UserInfoShortcodeInterface::class                => \DI\autowire( UserInfoShortcode::class ),
	//Collections
	CollectionInterface::class                       => \DI\autowire( Collection::class ),
	CreditAccountCollectionInterface::class          => \DI\autowire( CreditAccountCollection::class ),
	CreditGroupCollectionInterface::class            => \DI\autowire( CreditGroupCollection::class ),
	CreditTransactionCollectionInterface::class      => \DI\autowire( CreditTransactionCollection::class ),
	TcaRuleCheckResultCollectionInterface::class     => \DI\autowire( TcaRuleCheckResultCollection::class ),
	TcaRuleCollectionInterface::class                => \DI\autowire( TcaRuleCollection::class ),
	TermCollectionInterface::class                   => \DI\autowire( TermCollection::class ),
	TokenAddressCollectionInterface::class           => \DI\autowire( TokenAddressCollection::class ),
	TokenBalanceCollectionInterface::class           => \DI\autowire( TokenBalanceCollection::class ),
	TokenPromiseCollectionInterface::class           => \DI\autowire( TokenPromiseCollection::class ),
	TokenPromiseMetaCollectionInterface::class       => \DI\autowire( TokenPromiseMetaCollection::class ),
	TokenSourceCollectionInterface::class            => \DI\autowire( TokenSourceCollection::class ),
	TokenMetaCollectionInterface::class              => \DI\autowire( TokenMetaCollection::class ),
	PostCollectionInterface::class                   => \DI\autowire( PostCollection::class ),
	UserCollectionInterface::class                   => \DI\autowire( UserCollection::class ),
	WhitelistItemCollectionInterface::class          => \DI\autowire( WhitelistItemCollection::class ),
	//Models
	TokenAddressInterface::class           => \DI\autowire( TokenAddress::class ),
	TokenBalanceInterface::class           => \DI\autowire( TokenBalance::class ),
	CreditAccountInterface::class          => \DI\autowire( CreditAccount::class ),
	CreditAccountHistoryInterface::class   => \DI\autowire( CreditAccountHistory::class ),
	CreditGroupInterface::class            => \DI\autowire( CreditGroup::class ),
	CreditGroupHistoryInterface::class     => \DI\autowire( CreditGroupHistory::class ),
	CreditTransactionInterface::class      => \DI\autowire( CreditTransaction::class ),
	IntegrationInterface::class            => \DI\autowire( Integration::class ),
	OauthUserInterface::class              => \DI\autowire( OauthUser::class ),
	PostInterface::class                   => \DI\autowire( Post::class ),
	TcaAccessVerdictInterface::class       => \DI\autowire( TcaAccessVerdict::class ),
	TcaRuleCheckResultInterface::class     => \DI\autowire( TcaRuleCheckResult::class ),
	TcaRuleInterface::class                => \DI\autowire( TcaRule::class ),
	TokenPromiseInterface::class           => \DI\autowire( TokenPromise::class ),
	TokenPromiseMetaInterface::class       => \DI\autowire( TokenPromiseMeta::class ), 
	TokenQuantityInterface::class          => \DI\autowire( TokenQuantity::class ),
	TokenSourceInterface::class            => \DI\autowire( TokenSource::class ),
	TokenMetaInterface::class              => \DI\autowire( TokenMeta::class ), 
	TermInterface::class                   => \DI\autowire( Term::class ), 
	UserInterface::class                   => \DI\autowire( User::class ),
	//Models - Settings
	OauthSettingsInterface::class          => \DI\autowire( OauthSettings::class ),
	IntegrationSettingsInterface::class    => \DI\autowire( IntegrationSettings::class ),
	TcaSettingsInterface::class            => \DI\autowire( TcaSettings::class ),
	WhitelistSettingsInterface::class      => \DI\autowire( WhitelistSettings::class ),
	WhitelistItemInterface::class          => \DI\autowire( WhitelistItem::class ),
	//Middleware - TCA
	TcaMenuItemFilterMiddlewareInterface::class    => \DI\autowire( TcaMenuItemFilterMiddleware::class ),
	TcaPostGuardMiddlewareInterface::class         => \DI\autowire( TcaPostGuardMiddleware::class )
		->constructorParameter( 'namespace', \DI\get( 'general.namespace' ) ),
	TcaPostResultsFilterMiddlewareInterface::class => \DI\autowire( TcaPostResultsFilterMiddleware::class ),
	//Factories - Models
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
	TcaAccessVerdictFactoryInterface::class         => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TcaAccessVerdictInterface::class ) extends ConcreteFactory implements TcaAccessVerdictFactoryInterface {};
	} ),
	TcaRuleCheckResultFactoryInterface::class       => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TcaRuleCheckResultInterface::class ) extends ConcreteFactory implements TcaRuleCheckResultFactoryInterface {};
	} ),
	TcaRuleFactoryInterface::class                  => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TcaRuleInterface::class ) extends ConcreteFactory implements TcaRuleFactoryInterface {};
	} ),
	TermFactoryInterface::class                     => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TermInterface::class ) extends ConcreteFactory implements TermFactoryInterface {};
	} ),
	TokenPromiseFactoryInterface::class             => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenPromiseInterface::class ) extends ConcreteFactory implements TokenPromiseFactoryInterface {};
	} ),
	TokenQuantityFactoryInterface::class            => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenQuantityInterface::class ) extends ConcreteFactory implements TokenQuantityFactoryInterface {};
	} ),
	TokenSourceFactoryInterface::class              => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenSourceInterface::class ) extends ConcreteFactory implements TokenSourceFactoryInterface {};
	} ),
	TokenAddressFactoryInterface::class             => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenAddressInterface::class ) extends ConcreteFactory implements TokenAddressFactoryInterface {};
	} ),
	TokenBalanceFactoryInterface::class             => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenBalanceInterface::class ) extends ConcreteFactory implements TokenBalanceFactoryInterface {};
	} ),
	TokenPromiseMetaFactoryInterface::class         => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenPromiseMetaInterface::class ) extends ConcreteFactory implements TokenPromiseMetaFactoryInterface, PostFactoryInterface {};
	} ),
	TokenMetaFactoryInterface::class                => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, TokenMetaInterface::class ) extends ConcreteFactory implements TokenMetaFactoryInterface, PostFactoryInterface {};
	} ),
	UserFactoryInterface::class                     => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, UserInterface::class ) extends ConcreteFactory implements UserFactoryInterface {};
	} ),
	WhitelistItemFactoryInterface::class            => \DI\factory( function( ContainerInterface $container ) {
		return new class( $container, WhitelistItemInterface::class ) extends ConcreteFactory implements WhitelistItemFactoryInterface {};
	} ),
	//Factories - Collections
	CreditAccountCollectionFactoryInterface::class        => \DI\factory( function( ContainerInterface $container, CreditAccountFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, CreditAccountCollectionInterface::class ) extends ConcreteCollectionFactory implements CreditAccountCollectionFactoryInterface {};
	} ),
	CreditGroupCollectionFactoryInterface::class          => \DI\factory( function( ContainerInterface $container, CreditGroupFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, CreditGroupCollectionInterface::class ) extends ConcreteCollectionFactory implements CreditGroupCollectionFactoryInterface {};
	} ),
	CreditTransactionCollectionFactoryInterface::class    => \DI\factory( function( ContainerInterface $container, CreditTransactionFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, CreditTransactionCollectionInterface::class ) extends ConcreteCollectionFactory implements CreditTransactionCollectionFactoryInterface {};
	} ),
	PostCollectionFactoryInterface::class                 => \DI\factory( function( ContainerInterface $container, PostFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, PostCollectionInterface::class ) extends ConcreteCollectionFactory implements PostCollectionFactoryInterface {};
	} ),
	TcaRuleCheckResultCollectionFactoryInterface::class   => \DI\factory( function( ContainerInterface $container, TcaRuleCheckResultFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TcaRuleCheckResultCollectionInterface::class ) extends ConcreteCollectionFactory implements TcaRuleCheckResultCollectionFactoryInterface {};
	} ),
	TcaRuleCollectionFactoryInterface::class              => \DI\factory( function( ContainerInterface $container, TcaRuleFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TcaRuleCollectionInterface::class ) extends ConcreteCollectionFactory implements TcaRuleCollectionFactoryInterface {};
	} ),
	TermCollectionFactoryInterface::class                 => \DI\factory( function( ContainerInterface $container, TermFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TermCollectionInterface::class ) extends ConcreteCollectionFactory implements TermCollectionFactoryInterface {};
	} ),
	TokenMetaCollectionFactoryInterface::class            => \DI\factory( function( ContainerInterface $container, TokenMetaFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenMetaCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenMetaCollectionFactoryInterface, PostCollectionFactoryInterface {};
	} ),
	TokenPromiseMetaCollectionFactoryInterface::class     => \DI\factory( function( ContainerInterface $container, TokenPromiseMetaFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenPromiseMetaCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenPromiseMetaCollectionFactoryInterface, PostCollectionFactoryInterface {};
	} ),
	TokenSourceCollectionFactoryInterface::class          => \DI\factory( function( ContainerInterface $container, TokenSourceFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenSourceCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenSourceCollectionFactoryInterface {};
	} ),
	TokenPromiseCollectionFactoryInterface::class         => \DI\factory( function( ContainerInterface $container, TokenPromiseFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenPromiseCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenPromiseCollectionFactoryInterface {};
	} ),
	TokenAddressCollectionFactoryInterface::class         => \DI\factory( function( ContainerInterface $container, TokenAddressFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenAddressCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenAddressCollectionFactoryInterface {};
	} ),
	TokenBalanceCollectionFactoryInterface::class         => \DI\factory( function( ContainerInterface $container, TokenBalanceFactoryInterface $item_factory ) {
		return new class( $container, $item_factory, TokenBalanceCollectionInterface::class ) extends ConcreteCollectionFactory implements TokenBalanceCollectionFactoryInterface {};
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

	protected function is_valid_item( $item ) {
		return ( $item && is_subclass_of( $item, $this->item_factory->class ) );
	}

	public function create( array $data = array(), $args = array() ) {
		$items = array();
		foreach ( $data as $item ) {
			if ( $this->is_valid_item( $item ) ) {
				$items[] = $item;
				continue;
			}
			if ( !$item || !is_array( $item ) ) {
				continue;
			}
			$item = $this->item_factory->create( $item );
			if ( $this->is_valid_item( $item ) ) {
				$items[] = $item;
			}
		}
		$collection = $this->container->make( $this->class, array(
			'items' => $items,
		) );
		return $collection;
	}
}
