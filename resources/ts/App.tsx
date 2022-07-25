import '/resources/scss/Main.scss'
import { Container } from 'inversify'

import ServiceProviderInterface
	from './Interfaces/Providers/ServiceProviderInterface'

export default class App {
	container: Container
	constructor( container: Container ) {
		this.container = container
		this.registerProviders()
	}
	
	get providers() {
		return [
			//
		] as Array<any>
	}
	
	protected registerProviders() {
		this.providers.forEach( provider => {
			const providerInstance = 
				this.container.get( provider ) as ServiceProviderInterface
			providerInstance.register()
		} )
	}
}
