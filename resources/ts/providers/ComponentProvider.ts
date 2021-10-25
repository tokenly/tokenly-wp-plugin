import { injectable, inject } from 'inversify';
import { Component, Provider } from '../interfaces';

interface ComponentData {
	name: string,
	selector: string,
}

@injectable()
export class ComponentProvider implements Provider {
	componentFactory : any;
	constructor(
		@inject("Factory<Component>") componentFactory: (named: string) => Component
	) {
		this.componentFactory = componentFactory;
	}
	
	get components() {
		return [
			{
				name: 'buttonLoginComponent',
				selector: 'button.tokenpass-login',
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