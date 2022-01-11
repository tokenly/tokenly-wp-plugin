const TYPES = {
	Variables: {
		adminUrl: Symbol.for( 'adminUrl' ),
		adminPageUrl: Symbol.for( 'adminPageUrl' ),
		namespace: Symbol.for( 'namespace' ),
	},
	Components: {
		LoginButtonComponentInterface       : Symbol.for( 'LoginButtonComponentInterface' ),
		TokenItemCardComponentInterface     : Symbol.for( 'TokenItemCardComponentInterface' ),
	},
	Services: {
		AuthServiceInterface                : Symbol.for( 'AuthServiceInterface' ),
		AdminApiServiceInterface            : Symbol.for( 'AdminApiServiceInterface' ),
	},
	Providers: {
		ComponentServiceProviderInterface   : Symbol.for( 'ComponentServiceProviderInterface' ),
	},
	Repositories: {
		UserRepositoryInterface             : Symbol.for( 'UserRepositoryInterface' ),
		Credit: {
			GroupRepositoryInterface        : Symbol.for( 'GroupRepositoryInterface' ),
			TransactionRepositoryInterface  : Symbol.for( 'TransactionRepositoryInterface' ),
		},
		Settings: {
			OauthSettingsRepositoryInterface        : Symbol.for( 'OauthSettingsRepositoryInterface' ),
			IntegrationSettingsRepositoryInterface  : Symbol.for( 'IntegrationSettingsRepositoryInterface' ),
			TcaSettingsRepositoryInterface          : Symbol.for( 'TcaSettingsRepositoryInterface' ),
			WhitelistSettingsRepositoryInterface    : Symbol.for( 'WhitelistSettingsRepositoryInterface' ),
		},
		Token: {
			AddressRepositoryInterface  : Symbol.for( 'AddressRepositoryInterface' ),
			BalanceRepositoryInterface  : Symbol.for( 'BalanceRepositoryInterface' ),
			PromiseRepositoryInterface  : Symbol.for( 'PromiseRepositoryInterface' ),
			SourceRepositoryInterface   : Symbol.for( 'SourceRepositoryInterface' ),
			MetaRepositoryInterface     : Symbol.for( 'MetaRepositoryInterface' ),
		},
	},
	Routes: {
		AdminRouterInterface : Symbol.for( 'AdminRouterInterface' ),
	},
};

export { TYPES };
