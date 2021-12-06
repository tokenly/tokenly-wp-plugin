import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { TYPES } from './Types';
import { Component } from './Interfaces';
// Implementations
// Implementations - Services
import { AuthService } from './Services/AuthService';
import { AdminApiService } from './Services/AdminApiService';
// Implementations - Repositories
import { CreditGroupRepository } from './Repositories/CreditGroupRepository';
import { PromiseRepository } from './Repositories/PromiseRepository';
import { UserRepository } from './Repositories/UserRepository';
import { SourceRepository } from './Repositories/SourceRepository';
import { TokenMetaRepository } from './Repositories/TokenMetaRepository';
// Implementations - Repositories - Settings
import { IntegrationSettingsRepository } from './Repositories/Settings/IntegrationSettingsRepository';
import { TcaSettingsRepository } from './Repositories/Settings/TcaSettingsRepository';
import { OauthSettingsRepository } from './Repositories/Settings/OauthSettingsRepository';
import { WhitelistSettingsRepository } from './Repositories/Settings/WhitelistSettingsRepository';
// Implementations - Service providers
import { ComponentServiceProvider } from './Providers/ComponentServiceProvider';
// Implementations - Components
import { ButtonLoginComponent } from './Components/ButtonLoginComponent';
import { CardTokenItemComponent } from './Components/CardTokenItemComponent';
// Interfaces
// Interfaces - Services
import { AuthServiceInterface } from './Interfaces/Services/AuthServiceInterface';
import { AdminApiServiceInterface } from './Interfaces/Services/AdminApiServiceInterface';
// Interfaces - Repositories
import { CreditGroupRepositoryInterface } from './Interfaces/Repositories/CreditGroupRepositoryInterface';
import { PromiseRepositoryInterface } from './Interfaces/Repositories/PromiseRepositoryInterface';
import { SourceRepositoryInterface } from './Interfaces/Repositories/SourceRepositoryInterface';
import { TokenMetaRepositoryInterface } from './Interfaces/Repositories/TokenMetaRepositoryInterface';
import { UserRepositoryInterface } from './Interfaces/Repositories/UserRepositoryInterface';
// Interfaces - Repositories - Settings
import { IntegrationSettingsRepositoryInterface } from './Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';
import { TcaSettingsRepositoryInterface } from './Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';
import { OauthSettingsRepositoryInterface } from './Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';
import { WhitelistSettingsRepositoryInterface } from './Interfaces/Repositories/Settings/WhitelistSettingsRepositoryInterface';
// Interfaces - Components
import { ComponentServiceProviderInterface } from './Interfaces/Providers/ComponentServiceProviderInterface';
import { ButtonLoginComponentInterface } from './Interfaces/Components/ButtonLoginComponentInterface';
import { CardTokenItemComponentInterface } from './Interfaces/Components/CardTokenItemComponentInterface';

const container = new Container();

// Services - Application
container.bind<AuthServiceInterface>( TYPES.AuthServiceInterface ).to( AuthService );
container.bind<AdminApiServiceInterface>( TYPES.AdminApiServiceInterface ).to( AdminApiService );
// Repositories
container.bind<CreditGroupRepositoryInterface>( TYPES.CreditGroupRepositoryInterface ).to( CreditGroupRepository );
container.bind<PromiseRepositoryInterface>( TYPES.PromiseRepositoryInterface ).to( PromiseRepository );
container.bind<SourceRepositoryInterface>( TYPES.SourceRepositoryInterface ).to( SourceRepository );
container.bind<TokenMetaRepositoryInterface>( TYPES.TokenMetaRepositoryInterface ).to( TokenMetaRepository );
container.bind<UserRepositoryInterface>( TYPES.UserRepositoryInterface ).to( UserRepository );
// Repositories - Settings
container.bind<WhitelistSettingsRepositoryInterface>( TYPES.WhitelistSettingsRepositoryInterface ).to( WhitelistSettingsRepository );
container.bind<IntegrationSettingsRepositoryInterface>( TYPES.IntegrationSettingsRepositoryInterface ).to( IntegrationSettingsRepository );
container.bind<OauthSettingsRepositoryInterface>( TYPES.OauthSettingsRepositoryInterface ).to( OauthSettingsRepository );
container.bind<TcaSettingsRepositoryInterface>( TYPES.TcaSettingsRepositoryInterface ).to( TcaSettingsRepository );
// Components
container.bind<ComponentServiceProviderInterface>( TYPES.ComponentServiceProviderInterface ).to( ComponentServiceProvider );
container.bind<ButtonLoginComponentInterface>( TYPES.ButtonLoginComponentInterface ).to( ButtonLoginComponent );
container.bind<CardTokenItemComponentInterface>( TYPES.CardTokenItemComponentInterface ).to( CardTokenItemComponent );

container.bind<Component>( 'Component' ).to( ButtonLoginComponent ).whenTargetNamed( 'buttonLoginComponent' );
container.bind<Component>( 'Component' ).to( CardTokenItemComponent ).whenTargetNamed( 'cardTokenItemComponent' );
container.bind<interfaces.AutoNamedFactory<Component>>( 'Factory<Component>' )
		.toAutoNamedFactory<Component>( 'Component' );
		
export { container };
