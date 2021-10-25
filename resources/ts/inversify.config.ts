import 'reflect-metadata';
import { Container, interfaces } from "inversify";
import { AuthService } from './services/AuthService';
import { SettingsRepository } from './repositories/SettingsRepository';
import { VendorRepository } from './repositories/VendorRepository';
import { WhitelistRepository } from './repositories/WhitelistRepository';
import { ComponentProvider } from './providers/ComponentProvider';
import { ButtonLoginComponent } from './components/ButtonLoginComponent';
import { Component } from './interfaces';
import { TYPES } from "./types";


const container = new Container();

const services = [
	AuthService,
	SettingsRepository,
	VendorRepository,
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