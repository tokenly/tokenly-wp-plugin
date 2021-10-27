import { container } from './inversify.config';
import '/resources/scss/main.scss';

import { ComponentProvider } from './providers/ComponentProvider';

export default class App {
	container = container;
	constructor() {
		const componentProvider = this.container.get( ComponentProvider );
		componentProvider.register();
	}
	
	get providers() {
		return [
			ComponentProvider,
		] as Array<any>;
	}
	
	registerProviders() {
		this.providers.forEach( provider => {
			provider.register();
		} )
	}
}
