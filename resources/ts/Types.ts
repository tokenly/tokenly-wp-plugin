const TYPES = {
	// Services
	AuthServiceInterface                    : Symbol.for( 'AuthServiceInterface' ),
	AdminApiServiceInterface                : Symbol.for( 'AdminApiServiceInterface' ),
	// Repositories
	CreditGroupRepositoryInterface          : Symbol.for( 'CreditGroupRepositoryInterface' ),
	CreditTransactionRepositoryInterface    : Symbol.for( 'CreditTransactionRepositoryInterface' ),
	TokenPromiseRepositoryInterface         : Symbol.for( 'TokenPromiseRepositoryInterface' ),
	TokenSourceRepositoryInterface          : Symbol.for( 'TokenSourceRepositoryInterface' ),
	TokenMetaRepositoryInterface            : Symbol.for( 'TokenMetaRepositoryInterface' ),
	UserRepositoryInterface                 : Symbol.for( 'UserRepositoryInterface' ),
	// Repositories - Settings
	OauthSettingsRepositoryInterface        : Symbol.for( 'OauthSettingsRepositoryInterface' ),
	IntegrationSettingsRepositoryInterface  : Symbol.for( 'IntegrationSettingsRepositoryInterface' ),
	TcaSettingsRepositoryInterface          : Symbol.for( 'TcaSettingsRepositoryInterface' ),
	WhitelistSettingsRepositoryInterface    : Symbol.for( 'WhitelistSettingsRepositoryInterface' ),
	// Service providers
	ComponentServiceProviderInterface       : Symbol.for( 'ComponentServiceProviderInterface' ),
	// Components
	LoginButtonComponentInterface           : Symbol.for( 'LoginButtonComponentInterface' ),
	TokenItemCardComponentInterface         : Symbol.for( 'TokenItemCardComponentInterface' ),
};

export { TYPES };
