import 'reflect-metadata';
import { Container } from "inversify";
import { AuthService } from './services/AuthService';
import { SettingsService } from './services/SettingsService';
import { WhitelistService } from './services/WhitelistService';
import { ButtonLoginComponent } from './../../app/Components/ButtonLoginComponent';

const appContainer = new Container();

const services = [
	AuthService,
	SettingsService,
	WhitelistService,
	ButtonLoginComponent,
];

services.forEach( ( service: any ) => {
	appContainer.bind( service ).toSelf();
} );

export { appContainer };