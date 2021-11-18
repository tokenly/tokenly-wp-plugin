import { injectable } from 'inversify';
import { Component } from './Component';

@injectable()
export class CardTokenItemComponent extends Component {
	element: HTMLElement;
	
	constructor() {
		super();
	}
	
	register( selector: string ) {
		this.element.addEventListener( 'click', () => {
			this.element.classList.add( 'extra-shown' );
		} );
	}
}
