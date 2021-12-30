import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { TYPES } from './Types';
import { Component } from './Interfaces';
// Implementations
import AdminRouter from './Routes/AdminRouter';
// Implementations - Services
import AuthService from './Services/AuthService';
import AdminApiService from './Services/AdminApiService';
// Implementations - Repositories
import CreditGroupRepository from './Repositories/Credit/GroupRepository';
import CreditTransactionRepository from './Repositories/Credit/TransactionRepository';
import TokenAddressRepository from './Repositories/Token/AddressRepository';
import TokenBalanceRepository from './Repositories/Token/BalanceRepository';
import TokenPromiseRepository from './Repositories/Token/PromiseRepository';
import TokenSourceRepository from './Repositories/Token/SourceRepository';
import TokenMetaRepository from './Repositories/Token/MetaRepository';
import UserRepository from './Repositories/UserRepository';
// Implementations - Repositories - Settings
import IntegrationSettingsRepository from './Repositories/Settings/IntegrationSettingsRepository';
import TcaSettingsRepository from './Repositories/Settings/TcaSettingsRepository';
import OauthSettingsRepository from './Repositories/Settings/OauthSettingsRepository';
import WhitelistSettingsRepository from './Repositories/Settings/WhitelistSettingsRepository';
// Implementations - Service providers
import ComponentServiceProvider from './Providers/ComponentServiceProvider';
// Implementations - Components
import LoginButtonComponent from './Components/LoginButtonComponent';
import TokenItemCardComponent from './Components/TokenItemCardComponent';
// Interfaces
import AdminRouterInterface from './Interfaces/Routes/AdminRouterInterface';
// Interfaces - Services
import AuthServiceInterface from './Interfaces/Services/AuthServiceInterface';
import AdminApiServiceInterface from './Interfaces/Services/AdminApiServiceInterface';
// Interfaces - Repositories
import CreditGroupRepositoryInterface from './Interfaces/Repositories/Credit/GroupRepositoryInterface';
import CreditTransactionRepositoryInterface from './Interfaces/Repositories/Credit/TransactionRepositoryInterface';
import TokenAddressRepositoryInterface from './Interfaces/Repositories/Token/AddressRepositoryInterface';
import TokenBalanceRepositoryInterface from './Interfaces/Repositories/Token/BalanceRepositoryInterface';
import TokenPromiseRepositoryInterface from './Interfaces/Repositories/Token/PromiseRepositoryInterface';
import TokenSourceRepositoryInterface from './Interfaces/Repositories/Token/SourceRepositoryInterface';
import TokenMetaRepositoryInterface from './Interfaces/Repositories/Token/MetaRepositoryInterface';
import UserRepositoryInterface from './Interfaces/Repositories/UserRepositoryInterface';
// Interfaces - Repositories - Settings
import IntegrationSettingsRepositoryInterface from './Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';
import TcaSettingsRepositoryInterface from './Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';
import OauthSettingsRepositoryInterface from './Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';
import WhitelistSettingsRepositoryInterface from './Interfaces/Repositories/Settings/WhitelistSettingsRepositoryInterface';
// Interfaces - Components
import ComponentServiceProviderInterface from './Interfaces/Providers/ComponentServiceProviderInterface';
import LoginButtonComponentInterface from './Interfaces/Components/LoginButtonComponentInterface';
import TokenItemCardComponentInterface from './Interfaces/Components/TokenItemCardComponentInterface';

const container = new Container();

container.bind<AdminRouterInterface>( TYPES.Routes.AdminRouterInterface ).to( AdminRouter );
// Services - Application
container.bind<AuthServiceInterface>( TYPES.Services.AuthServiceInterface ).to( AuthService );
container.bind<AdminApiServiceInterface>( TYPES.Services.AdminApiServiceInterface ).to( AdminApiService );
// Repositories
container.bind<CreditGroupRepositoryInterface>( TYPES.Repositories.Credit.GroupRepositoryInterface ).to( CreditGroupRepository );
container.bind<CreditTransactionRepositoryInterface>( TYPES.Repositories.Credit.TransactionRepositoryInterface ).to( CreditTransactionRepository );
container.bind<TokenAddressRepositoryInterface>( TYPES.Repositories.Token.AddressRepositoryInterface ).to( TokenAddressRepository );
container.bind<TokenBalanceRepositoryInterface>( TYPES.Repositories.Token.BalanceRepositoryInterface ).to( TokenBalanceRepository );
container.bind<TokenPromiseRepositoryInterface>( TYPES.Repositories.Token.PromiseRepositoryInterface ).to( TokenPromiseRepository );
container.bind<TokenSourceRepositoryInterface>( TYPES.Repositories.Token.SourceRepositoryInterface ).to( TokenSourceRepository );
container.bind<TokenMetaRepositoryInterface>( TYPES.Repositories.Token.MetaRepositoryInterface ).to( TokenMetaRepository );
container.bind<UserRepositoryInterface>( TYPES.Repositories.UserRepositoryInterface ).to( UserRepository );
// Repositories - Settings
container.bind<WhitelistSettingsRepositoryInterface>( TYPES.Repositories.Settings.WhitelistSettingsRepositoryInterface ).to( WhitelistSettingsRepository );
container.bind<IntegrationSettingsRepositoryInterface>( TYPES.Repositories.Settings.IntegrationSettingsRepositoryInterface ).to( IntegrationSettingsRepository );
container.bind<OauthSettingsRepositoryInterface>( TYPES.Repositories.Settings.OauthSettingsRepositoryInterface ).to( OauthSettingsRepository );
container.bind<TcaSettingsRepositoryInterface>( TYPES.Repositories.Settings.TcaSettingsRepositoryInterface ).to( TcaSettingsRepository );
// Providers
container.bind<ComponentServiceProviderInterface>( TYPES.Providers.ComponentServiceProviderInterface ).to( ComponentServiceProvider );
// Components
container.bind<LoginButtonComponentInterface>( TYPES.Components.LoginButtonComponentInterface ).to( LoginButtonComponent );
container.bind<TokenItemCardComponentInterface>( TYPES.Components.TokenItemCardComponentInterface ).to( TokenItemCardComponent );

container.bind<Component>( 'Component' ).to( LoginButtonComponent ).whenTargetNamed( 'loginButtonComponent' );
container.bind<Component>( 'Component' ).to( TokenItemCardComponent ).whenTargetNamed( 'tokenItemCardComponent' );
container.bind<interfaces.AutoNamedFactory<Component>>( 'Factory<Component>' )
		.toAutoNamedFactory<Component>( 'Component' );
	
container.bind<string>( TYPES.Variables.adminUrl ).toConstantValue( '/wp-admin/admin.php?page=' );
container.bind<string>( TYPES.Variables.namespace ).toConstantValue( 'tokenly' );

export { container };
