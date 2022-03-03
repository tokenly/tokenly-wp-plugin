import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { TYPES } from './Types';
// Implementations - Services
import AuthService from './Services/AuthService';
import ApiService from './Services/ApiService';
import CreditVendorService from './Services/Application/Credit/VendorService';
import TokenVendorService from './Services/Application/Token/VendorService';
// Implementations - Repositories
import CreditGroupRepository from './Repositories/Credit/GroupRepository';
import CreditTransactionRepository from './Repositories/Credit/TransactionRepository';
import TokenAddressRepository from './Repositories/Token/AddressRepository';
import TokenPromiseRepository from './Repositories/Token/PromiseRepository';
import TokenSourceRepository from './Repositories/Token/SourceRepository';
import TokenWhitelistRepository from './Repositories/Token/WhitelistRepository';
import UserRepository from './Repositories/UserRepository';
// Implementations - Repositories - Settings
import IntegrationSettingsRepository from './Repositories/Settings/IntegrationSettingsRepository';
import TcaSettingsRepository from './Repositories/Settings/TcaSettingsRepository';
import OauthSettingsRepository from './Repositories/Settings/OauthSettingsRepository';
import CreditWhitelistSettingsRepository from './Repositories/Settings/CreditWhitelistSettingsRepository';
// Interfaces - Services
import AuthServiceInterface from './Interfaces/Services/AuthServiceInterface';
import { ApiServiceInterface } from './Interfaces/Services/ApiServiceInterface';
import CreditVendorServiceInterface from './Interfaces/Services/Application/Credit/VendorServiceInterface';
import TokenVendorServiceInterface from './Interfaces/Services/Application/Token/VendorServiceInterface';
// Interfaces - Repositories
import CreditGroupRepositoryInterface from './Interfaces/Repositories/Credit/GroupRepositoryInterface';
import CreditTransactionRepositoryInterface from './Interfaces/Repositories/Credit/TransactionRepositoryInterface';
import TokenAddressRepositoryInterface from './Interfaces/Repositories/Token/AddressRepositoryInterface';
import TokenPromiseRepositoryInterface from './Interfaces/Repositories/Token/PromiseRepositoryInterface';
import TokenSourceRepositoryInterface from './Interfaces/Repositories/Token/SourceRepositoryInterface';
import TokenWhitelistRepositoryInterface from './Interfaces/Repositories/Token/WhitelistRepositoryInterface';
import UserRepositoryInterface from './Interfaces/Repositories/UserRepositoryInterface';
// Interfaces - Repositories - Settings
import IntegrationSettingsRepositoryInterface from './Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';
import TcaSettingsRepositoryInterface from './Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';
import OauthSettingsRepositoryInterface from './Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';
import CreditWhitelistSettingsRepositoryInterface from './Interfaces/Repositories/Settings/CreditWhitelistSettingsRepositoryInterface';

declare const window: any;

export default function bind( container: Container ) {
	// Services - Application
	container.bind<AuthServiceInterface>( TYPES.Services.AuthServiceInterface ).to( AuthService );
	container.bind<ApiServiceInterface>( TYPES.Services.ApiServiceInterface ).to( ApiService );
	container.bind<CreditVendorServiceInterface>( TYPES.Services.Application.Credit.VendorServiceInterface ).to( CreditVendorService );
	container.bind<TokenVendorServiceInterface>( TYPES.Services.Application.Token.VendorServiceInterface ).to( TokenVendorService );
	// Repositories
	container.bind<CreditGroupRepositoryInterface>( TYPES.Repositories.Credit.GroupRepositoryInterface ).to( CreditGroupRepository );
	container.bind<CreditTransactionRepositoryInterface>( TYPES.Repositories.Credit.TransactionRepositoryInterface ).to( CreditTransactionRepository );
	container.bind<TokenAddressRepositoryInterface>( TYPES.Repositories.Token.AddressRepositoryInterface ).to( TokenAddressRepository );
	container.bind<TokenPromiseRepositoryInterface>( TYPES.Repositories.Token.PromiseRepositoryInterface ).to( TokenPromiseRepository );
	container.bind<TokenSourceRepositoryInterface>( TYPES.Repositories.Token.SourceRepositoryInterface ).to( TokenSourceRepository );
	container.bind<TokenWhitelistRepositoryInterface>( TYPES.Repositories.Token.WhitelistRepositoryInterface ).to( TokenWhitelistRepository );
	container.bind<UserRepositoryInterface>( TYPES.Repositories.UserRepositoryInterface ).to( UserRepository );
	// Repositories - Settings
	container.bind<CreditWhitelistSettingsRepositoryInterface>( TYPES.Repositories.Settings.CreditWhitelistSettingsRepositoryInterface ).to( CreditWhitelistSettingsRepository );;
	container.bind<IntegrationSettingsRepositoryInterface>( TYPES.Repositories.Settings.IntegrationSettingsRepositoryInterface ).to( IntegrationSettingsRepository );
	container.bind<OauthSettingsRepositoryInterface>( TYPES.Repositories.Settings.OauthSettingsRepositoryInterface ).to( OauthSettingsRepository );
	container.bind<TcaSettingsRepositoryInterface>( TYPES.Repositories.Settings.TcaSettingsRepositoryInterface ).to( TcaSettingsRepository );

	container.bind<string>( TYPES.Variables.adminUrl ).toConstantValue( '/wp-admin/' );
	container.bind<string>( TYPES.Variables.adminPageUrl ).toConstantValue( '/wp-admin/admin.php?page=' );
	container.bind<string>( TYPES.Variables.brand ).toConstantValue( 'Tokenly' );
	container.bind<string>( TYPES.Variables.namespace ).toConstantValue( 'tokenly' );
	container.bind<string>( TYPES.Variables.apiHost ).toConstantValue( 'https://tokenpass.tokenly.com' );
	container.bind<string>( TYPES.Variables.pluginUrl ).toConstantValue( '/wp-content/plugins/tokenly-wp-plugin' );

	console.log(window.tokenpassData);
	const shared = window?.tokenpassData?.shared;
	container.bind<string>( TYPES.Variables.nonce ).toConstantValue( shared?.nonce ?? null );
	container.bind<string>( TYPES.Variables.routes ).toConstantValue( shared?.routes ?? null );
	container.bind<string>( TYPES.Variables.fallbackImage ).toConstantValue( shared?.fallback_image ?? null );
	container.bind<string>( TYPES.Variables.isUserConnected ).toConstantValue( shared?.user_can_connect ?? false );
	container.bind<string>( TYPES.Variables.isIntegrationConnected ).toConstantValue( shared?.integration_can_connect ?? false );
	return container;
}




