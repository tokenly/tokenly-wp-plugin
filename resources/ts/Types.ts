const TYPES = {
	Variables: {
		adminUrl               : Symbol.for(
			'adminUrl' ),
		adminPageUrl           : Symbol.for(
			'adminPageUrl' ),
		apiHost                : Symbol.for(
			'apiHost' ),
		brand                  : Symbol.for(
			'brand' ),
		namespace              : Symbol.for(
			'namespace' ),
		pluginUrl              : Symbol.for(
			'pluginUrl' ),
		nonce                  : Symbol.for(
			'nonce' ),
		routes                 : Symbol.for(
			'routes' ),
		fallbackImage          : Symbol.for(
			'fallbackImage' ),
		isUserConnected        : Symbol.for(
			'isUserConnected' ),
		isIntegrationConnected : Symbol.for(
			'isIntegrationConnected' ),
		dictionary : Symbol.for( 'dictionary' ),
		web3Provider : Symbol.for( 'web3Provider' ),
	},
	Services: {
		AuthServiceInterface  : Symbol.for(
			'AuthServiceInterface' ),
		ApiServiceInterface   : Symbol.for(
			'ApiServiceInterface' ),
		Application: {
			Credit : {
				VendorServiceInterface : Symbol.for(
					'CreditVendorServiceInterface' ),
			},
			Token  : {
				VendorServiceInterface : Symbol.for(
					'TokenVendorServiceInterface' ),
			},
		}
	},
	Repositories: {
		UserRepositoryInterface             : Symbol.for(
			'UserRepositoryInterface' ),
		Credit: {
			GroupRepositoryInterface        : Symbol.for(
				'GroupRepositoryInterface' ),
			TransactionRepositoryInterface  : Symbol.for(
				'TransactionRepositoryInterface' ),
		},
		Settings: {
			OauthSettingsRepositoryInterface           : Symbol.for(
				'OauthSettingsRepositoryInterface' ),
			IntegrationSettingsRepositoryInterface     : Symbol.for(
				'IntegrationSettingsRepositoryInterface' ),
			TcaSettingsRepositoryInterface             : Symbol.for(
				'TcaSettingsRepositoryInterface' ),
			CreditWhitelistSettingsRepositoryInterface : Symbol.for(
				'CreditWhitelistSettingsRepositoryInterface' ),
			TokenWhitelistSettingsRepositoryInterface  : Symbol.for(
				'TokenWhitelistSettingsRepositoryInterface' ),
		},
		Token: {
			AddressRepositoryInterface     : Symbol.for(
				'AddressRepositoryInterface' ),
			BalanceRepositoryInterface     : Symbol.for(
				'BalanceRepositoryInterface' ),
			PromiseRepositoryInterface     : Symbol.for(
				'PromiseRepositoryInterface' ),
			SourceRepositoryInterface      : Symbol.for(
				'SourceRepositoryInterface' ),
			MetaRepositoryInterface        : Symbol.for(
				'MetaRepositoryInterface' ),
			WhitelistRepositoryInterface   : Symbol.for(
				'WhitelistRepositoryInterface' ),
		},
	},
	Routes: {
		AdminRouterInterface : Symbol.for( 'AdminRouterInterface' ),
	},
}

enum ApiScope {
	User = 'user',
	Tca = 'tca',
	PrivateBalances = 'private-balances',
	PrivateAddress = 'private-address',
	ManageAddress = 'manage-address'
  }

export { TYPES, ApiScope }
