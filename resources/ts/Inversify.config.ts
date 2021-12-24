import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { TYPES } from './Types';
import { Component } from './Interfaces';
// Implementations
// Implementations - Services
import AuthService from './Services/AuthService';
import AdminApiService from './Services/AdminApiService';
// Implementations - Repositories
import CreditGroupRepository from './Repositories/Credit/GroupRepository';
import CreditTransactionRepository from './Repositories/Credit/TransactionRepository';
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
import { ComponentServiceProvider } from './Providers/ComponentServiceProvider';
// Implementations - Components
import { LoginButtonComponent } from './Components/LoginButtonComponent';
import { TokenItemCardComponent } from './Components/TokenItemCardComponent';
// Interfaces
// Interfaces - Services
import AuthServiceInterface from './Interfaces/Services/AuthServiceInterface';
import AdminApiServiceInterface from './Interfaces/Services/AdminApiServiceInterface';
// Interfaces - Repositories
import CreditGroupRepositoryInterface from './Interfaces/Repositories/Credit/GroupRepositoryInterface';
import CreditTransactionRepositoryInterface from './Interfaces/Repositories/Credit/TransactionRepositoryInterface';
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
import { ComponentServiceProviderInterface } from './Interfaces/Providers/ComponentServiceProviderInterface';
import { LoginButtonComponentInterface } from './Interfaces/Components/LoginButtonComponentInterface';
import { TokenItemCardComponentInterface } from './Interfaces/Components/TokenItemCardComponentInterface';

const container = new Container();

// Services - Application
container.bind<AuthServiceInterface>( TYPES.AuthServiceInterface ).to( AuthService );
container.bind<AdminApiServiceInterface>( TYPES.AdminApiServiceInterface ).to( AdminApiService );
// Repositories
container.bind<CreditGroupRepositoryInterface>( TYPES.CreditGroupRepositoryInterface ).to( CreditGroupRepository );
container.bind<CreditTransactionRepositoryInterface>( TYPES.CreditTransactionRepositoryInterface ).to( CreditTransactionRepository );
container.bind<TokenPromiseRepositoryInterface>( TYPES.TokenPromiseRepositoryInterface ).to( TokenPromiseRepository );
container.bind<TokenSourceRepositoryInterface>( TYPES.TokenSourceRepositoryInterface ).to( TokenSourceRepository );
container.bind<TokenMetaRepositoryInterface>( TYPES.TokenMetaRepositoryInterface ).to( TokenMetaRepository );
container.bind<UserRepositoryInterface>( TYPES.UserRepositoryInterface ).to( UserRepository );
// Repositories - Settings
container.bind<WhitelistSettingsRepositoryInterface>( TYPES.WhitelistSettingsRepositoryInterface ).to( WhitelistSettingsRepository );
container.bind<IntegrationSettingsRepositoryInterface>( TYPES.IntegrationSettingsRepositoryInterface ).to( IntegrationSettingsRepository );
container.bind<OauthSettingsRepositoryInterface>( TYPES.OauthSettingsRepositoryInterface ).to( OauthSettingsRepository );
container.bind<TcaSettingsRepositoryInterface>( TYPES.TcaSettingsRepositoryInterface ).to( TcaSettingsRepository );
// Components
container.bind<ComponentServiceProviderInterface>( TYPES.ComponentServiceProviderInterface ).to( ComponentServiceProvider );
container.bind<LoginButtonComponentInterface>( TYPES.LoginButtonComponentInterface ).to( LoginButtonComponent );
container.bind<TokenItemCardComponentInterface>( TYPES.TokenItemCardComponentInterface ).to( TokenItemCardComponent );

container.bind<Component>( 'Component' ).to( LoginButtonComponent ).whenTargetNamed( 'loginButtonComponent' );
container.bind<Component>( 'Component' ).to( TokenItemCardComponent ).whenTargetNamed( 'tokenItemCardComponent' );
container.bind<interfaces.AutoNamedFactory<Component>>( 'Factory<Component>' )
		.toAutoNamedFactory<Component>( 'Component' );
		
export { container };
