import 'reflect-metadata'
import { Container, interfaces } from 'inversify'
import { TYPES } from './Types'
import AuthService from './Services/AuthService'
import ApiService from './Services/ApiService'
import CreditVendorService from './Services/Application/Credit/VendorService'
import TokenVendorService from './Services/Application/Token/VendorService'
import CreditGroupRepository from './Repositories/Credit/GroupRepository'
import CreditTransactionRepository from
	'./Repositories/Credit/TransactionRepository'
import TokenAddressRepository from './Repositories/Token/AddressRepository'
import TokenPromiseRepository from './Repositories/Token/PromiseRepository'
import TokenSourceRepository from './Repositories/Token/SourceRepository'
import TokenWhitelistRepository from
	'./Repositories/Token/WhitelistRepository'
import UserRepository from './Repositories/UserRepository'
import IntegrationSettingsRepository from
	'./Repositories/Settings/IntegrationSettingsRepository'
import TcaSettingsRepository from
	'./Repositories/Settings/TcaSettingsRepository'
import OauthSettingsRepository from
	'./Repositories/Settings/OauthSettingsRepository'
import CreditWhitelistSettingsRepository from
	'./Repositories/Settings/CreditWhitelistSettingsRepository'
import AuthServiceInterface from
	'./Interfaces/Services/AuthServiceInterface'
import { ApiServiceInterface } from
	'./Interfaces/Services/ApiServiceInterface'
import CreditVendorServiceInterface from
	'./Interfaces/Services/Application/Credit/VendorServiceInterface'
import TokenVendorServiceInterface from
	'./Interfaces/Services/Application/Token/VendorServiceInterface'
import CreditGroupRepositoryInterface from
	'./Interfaces/Repositories/Credit/GroupRepositoryInterface'
import CreditTransactionRepositoryInterface from
	'./Interfaces/Repositories/Credit/TransactionRepositoryInterface'
import TokenAddressRepositoryInterface from
	'./Interfaces/Repositories/Token/AddressRepositoryInterface'
import TokenPromiseRepositoryInterface from
	'./Interfaces/Repositories/Token/PromiseRepositoryInterface'
import TokenSourceRepositoryInterface from
	'./Interfaces/Repositories/Token/SourceRepositoryInterface'
import TokenWhitelistRepositoryInterface from
	'./Interfaces/Repositories/Token/WhitelistRepositoryInterface'
import UserRepositoryInterface from
	'./Interfaces/Repositories/UserRepositoryInterface'
import IntegrationSettingsRepositoryInterface from
	'./Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface'
import TcaSettingsRepositoryInterface from
	'./Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface'
import OauthSettingsRepositoryInterface from
	'./Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface'
import CreditWhitelistSettingsRepositoryInterface from
	'./Interfaces/Repositories/Settings/CreditWhitelistSettingsRepositoryInterface'
import RouteManager from './Models/RouteManager'
import RouteManagerInterface from './Interfaces/Models/RouteManagerInterface'
import Dictionary from './dictionary'
import DictionaryInterface from './Interfaces/DictionaryInterface'

declare const window: any

export default function bind( container: Container ) {
	container.bind<AuthServiceInterface>(
		TYPES.Services.AuthServiceInterface )
		.to( AuthService )
		.inSingletonScope()
	container.bind<ApiServiceInterface>(
		TYPES.Services.ApiServiceInterface )
		.to( ApiService )
		.inSingletonScope()
	container.bind<CreditVendorServiceInterface>(
		TYPES.Services.Application.Credit.VendorServiceInterface )
		.to( CreditVendorService )
		.inSingletonScope()
	container.bind<TokenVendorServiceInterface>(
		TYPES.Services.Application.Token.VendorServiceInterface )
		.to( TokenVendorService )
		.inSingletonScope()
	container.bind<CreditGroupRepositoryInterface>(
		TYPES.Repositories.Credit.GroupRepositoryInterface )
		.to( CreditGroupRepository )
		.inSingletonScope()
	container.bind<CreditTransactionRepositoryInterface>(
		TYPES.Repositories.Credit.TransactionRepositoryInterface )
		.to( CreditTransactionRepository )
		.inSingletonScope()
	container.bind<TokenAddressRepositoryInterface>(
		TYPES.Repositories.Token.AddressRepositoryInterface )
		.to( TokenAddressRepository )
		.inSingletonScope()
	container.bind<TokenPromiseRepositoryInterface>(
		TYPES.Repositories.Token.PromiseRepositoryInterface )
		.to( TokenPromiseRepository )
		.inSingletonScope()
	container.bind<TokenSourceRepositoryInterface>(
		TYPES.Repositories.Token.SourceRepositoryInterface )
		.to( TokenSourceRepository )
		.inSingletonScope()
	container.bind<TokenWhitelistRepositoryInterface>(
		TYPES.Repositories.Token.WhitelistRepositoryInterface )
		.to( TokenWhitelistRepository )
		.inSingletonScope()
	container.bind<UserRepositoryInterface>(
		TYPES.Repositories.UserRepositoryInterface )
		.to( UserRepository )
		.inSingletonScope()
	container.bind<CreditWhitelistSettingsRepositoryInterface>(
		TYPES.Repositories.Settings.CreditWhitelistSettingsRepositoryInterface )
		.to( CreditWhitelistSettingsRepository )
		.inSingletonScope()
	container.bind<IntegrationSettingsRepositoryInterface>(
		TYPES.Repositories.Settings.IntegrationSettingsRepositoryInterface )
		.to( IntegrationSettingsRepository )
		.inSingletonScope()
	container.bind<OauthSettingsRepositoryInterface>(
		TYPES.Repositories.Settings.OauthSettingsRepositoryInterface )
		.to( OauthSettingsRepository )
		.inSingletonScope()
	container.bind<TcaSettingsRepositoryInterface>(
		TYPES.Repositories.Settings.TcaSettingsRepositoryInterface )
		.to( TcaSettingsRepository )
		.inSingletonScope()
	container.bind<string>( TYPES.Variables.adminUrl )
		.toConstantValue( '/wp-admin/' )
	container.bind<string>( TYPES.Variables.adminPageUrl )
		.toConstantValue( '/wp-admin/admin.php?page=' )
	container.bind<string>( TYPES.Variables.brand )
		.toConstantValue( 'Tokenly' )
	container.bind<string>( TYPES.Variables.namespace )
		.toConstantValue( 'tokenly' )
	container.bind<string>( TYPES.Variables.apiHost )
		.toConstantValue( 'https://tokenpass.tokenly.com' )
	container.bind<string>( TYPES.Variables.pluginUrl )
		.toConstantValue( '/wp-content/plugins/tokenly-wp-plugin' )
	
	const shared = window?.tokenpassData?.shared
	container.bind<string>( TYPES.Variables.nonce )
		.toConstantValue( shared?.nonce ?? null )
	container.bind<string>( TYPES.Variables.fallbackImage )
		.toConstantValue( shared?.fallback_image ?? null )
	container.bind<string>( TYPES.Variables.isUserConnected )
		.toConstantValue( shared?.user_can_connect ?? false )
	container.bind<string>( TYPES.Variables.isIntegrationConnected )
		.toConstantValue( shared?.integration_can_connect ?? false )
	container.bind<DictionaryInterface>( TYPES.Variables.dictionary )
		.toDynamicValue((context: interfaces.Context) => {
			return new Dictionary( context.container.get( TYPES.Variables.brand ) ) 
		} )
		.inSingletonScope()
	container.bind<RouteManagerInterface>( TYPES.Variables.routes )
		.toDynamicValue( ( context: interfaces.Context ) => {
			return ( new RouteManager(
				context.container.get( TYPES.Variables.namespace )
			) ).fromJson( shared?.routes ) 
		} )
		.inSingletonScope()
	return container
}




