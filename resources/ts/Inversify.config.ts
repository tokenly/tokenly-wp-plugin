import 'reflect-metadata';
import { Container, interfaces } from 'inversify';
import { TYPES } from './Types';
import { Component } from './Interfaces';
import { AuthService } from './Services/AuthService';
import { SettingsRepository } from './Repositories/SettingsRepository';
import { PromiseRepository } from './Repositories/PromiseRepository';
import { UserRepository } from './Repositories/UserRepository';
import { SourceRepository } from './Repositories/SourceRepository';
import { WhitelistRepository } from './Repositories/WhitelistRepository';
import { TokenMetaRepository } from './Repositories/TokenMetaRepository';
import { ComponentServiceProvider } from './Providers/ComponentServiceProvider';
import { ButtonLoginComponent } from './Components/ButtonLoginComponent';
import { CardTokenItemComponent } from './Components/CardTokenItemComponent';
import { AdminApiService } from './Services/AdminApiService';
import { AuthServiceInterface } from './Interfaces/Services/AuthServiceInterface';
import { AdminApiServiceInterface } from './Interfaces/Services/AdminApiServiceInterface';
import { PromiseRepositoryInterface } from './Interfaces/Repositories/PromiseRepositoryInterface';
import { SettingsRepositoryInterface } from './Interfaces/Repositories/SettingsRepositoryInterface';
import { SourceRepositoryInterface } from './Interfaces/Repositories/SourceRepositoryInterface';
import { TokenMetaRepositoryInterface } from './Interfaces/Repositories/TokenMetaRepositoryInterface';
import { UserRepositoryInterface } from './Interfaces/Repositories/UserRepositoryInterface';
import { WhitelistRepositoryInterface } from './Interfaces/Repositories/WhitelistRepositoryInterface';
import { ComponentServiceProviderInterface } from './Interfaces/Providers/ComponentServiceProviderInterface';
import { ButtonLoginComponentInterface } from './Interfaces/Components/ButtonLoginComponentInterface';
import { CardTokenItemComponentInterface } from './Interfaces/Components/CardTokenItemComponentInterface';

const container = new Container();

container.bind<AuthServiceInterface>( TYPES.AuthServiceInterface ).to( AuthService );
container.bind<AdminApiServiceInterface>( TYPES.AdminApiServiceInterface ).to( AdminApiService );
container.bind<PromiseRepositoryInterface>( TYPES.PromiseRepositoryInterface ).to( PromiseRepository );
container.bind<SettingsRepositoryInterface>( TYPES.SettingsRepositoryInterface ).to( SettingsRepository );
container.bind<SourceRepositoryInterface>( TYPES.SourceRepositoryInterface ).to( SourceRepository );
container.bind<TokenMetaRepositoryInterface>( TYPES.TokenMetaRepositoryInterface ).to( TokenMetaRepository );
container.bind<UserRepositoryInterface>( TYPES.UserRepositoryInterface ).to( UserRepository );
container.bind<WhitelistRepositoryInterface>( TYPES.WhitelistRepositoryInterface ).to( WhitelistRepository );
container.bind<ComponentServiceProviderInterface>( TYPES.ComponentServiceProviderInterface ).to( ComponentServiceProvider );
container.bind<ButtonLoginComponentInterface>( TYPES.ButtonLoginComponentInterface ).to( ButtonLoginComponent );
container.bind<CardTokenItemComponentInterface>( TYPES.CardTokenItemComponentInterface ).to( CardTokenItemComponent );

container.bind<Component>( 'Component' ).to( ButtonLoginComponent ).whenTargetNamed( 'buttonLoginComponent' );
container.bind<Component>( 'Component' ).to( CardTokenItemComponent ).whenTargetNamed( 'cardTokenItemComponent' );
container.bind<interfaces.AutoNamedFactory<Component>>( 'Factory<Component>' )
		.toAutoNamedFactory<Component>( 'Component' );
		
export { container };
