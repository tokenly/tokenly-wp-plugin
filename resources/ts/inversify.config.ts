import 'reflect-metadata';
import { Container, interfaces } from "inversify";
import { TYPES } from "./types";
import { Component } from './interfaces';
import { AuthService } from './services/AuthService';
import { SettingsRepository } from './repositories/SettingsRepository';
import { PromiseRepository } from './repositories/PromiseRepository';
import { UserRepository } from './repositories/UserRepository';
import { SourceRepository } from './repositories/SourceRepository';
import { WhitelistRepository } from './repositories/WhitelistRepository';
import { TokenMetaRepository } from './repositories/TokenMetaRepository'
import { ComponentProvider } from './providers/ComponentProvider';
import { ButtonLoginComponent } from './components/ButtonLoginComponent';
import { AdminApiService } from './services/AdminApiService';

const container = new Container();

const services = [
	AuthService,
	AdminApiService,
	SettingsRepository,
	PromiseRepository,
	UserRepository,
	SourceRepository,
	WhitelistRepository,
	TokenMetaRepository,
	ButtonLoginComponent,
	ComponentProvider,
];

services.forEach( ( service: any ) => {
	container.bind( service ).toSelf();
} );

container.bind<Component>( 'Component' ).to( ButtonLoginComponent ).whenTargetNamed( 'buttonLoginComponent' );
container.bind<interfaces.AutoNamedFactory<Component>>( 'Factory<Component>' )
         .toAutoNamedFactory<Component>( 'Component' );
		 
export { container };
