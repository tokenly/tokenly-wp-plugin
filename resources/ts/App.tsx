import { container } from './Inversify.config';
import '/resources/scss/Main.scss';
import { TYPES } from './Types'; 

import ServiceProviderInterface from './Interfaces/Providers/ServiceProviderInterface';

export default class App {
	container = container;
	constructor() {
		this.registerProviders();
	}
	
	get providers() {
		return [
			TYPES.Providers.ComponentServiceProviderInterface,
		] as Array<any>;
	}
	
	registerProviders() {
		this.providers.forEach( provider => {
			const providerInstance = this.container.get( provider ) as ServiceProviderInterface;
			providerInstance.register();
		} )
	}
}
