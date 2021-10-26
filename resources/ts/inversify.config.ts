import 'reflect-metadata';
import { Container, interfaces } from "inversify";
import { TYPES } from "./types";
import { Component } from './interfaces';
import { AuthService } from './services/AuthService';
import { SettingsRepository } from './repositories/SettingsRepository';
import { PromiseRepository } from './repositories/PromiseRepository';
import { UserRepository } from './repositories/UserRepository';
import { WhitelistRepository } from './repositories/WhitelistRepository';
import { ComponentProvider } from './providers/ComponentProvider';
import { ButtonLoginComponent } from './components/ButtonLoginComponent';

const container = new Container();

const services = [
	AuthService,
	SettingsRepository,
	PromiseRepository,
	UserRepository,
	WhitelistRepository,
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