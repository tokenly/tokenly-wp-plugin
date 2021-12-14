const TYPES = {
	// Services
	AuthServiceInterface                    : Symbol.for( 'AuthServiceInterface' ),
	AdminApiServiceInterface                : Symbol.for( 'AdminApiServiceInterface' ),
	// Repositories
	PromiseRepositoryInterface              : Symbol.for( 'PromiseRepositoryInterface' ),
	CreditGroupRepositoryInterface          : Symbol.for( 'CreditGroupRepositoryInterface' ),
	CreditTransactionRepositoryInterface    : Symbol.for( 'CreditTransactionRepositoryInterface' ),
	SourceRepositoryInterface               : Symbol.for( 'SourceRepositoryInterface' ),
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
