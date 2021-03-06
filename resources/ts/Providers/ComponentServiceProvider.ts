import { injectable, inject } from 'inversify';
import { Component, ComponentData } from '../Interfaces';
import ServiceProvider from './ServiceProvider';
import ComponentServiceProviderInterface from './../Interfaces/Providers/ComponentServiceProviderInterface';

@injectable()
export default class ComponentServiceProvider extends ServiceProvider implements ComponentServiceProviderInterface {
	componentFactory : any;
	constructor(
		@inject("Factory<Component>") componentFactory: (named: string) => Component
	) {
		super();
		this.componentFactory = componentFactory;
	}
	
	get components() {
		return [
			{
				name: 'loginButtonComponent',
				selector: 'a.tokenpass-login',
			},
			{
				name: 'tokenItemCardComponent',
				selector: '.component-card-token-item',
			}
		];
	}
	
	register() {
		this.components.forEach( ( component: ComponentData ) => {
			const elements: NodeListOf<HTMLElement> = document.querySelectorAll( component.selector );
			elements.forEach( ( element: any ) => {
				const componentInstance = this.componentFactory( component.name );
				componentInstance.element = element;
				componentInstance.register();
			} )
		} )
	}
}
