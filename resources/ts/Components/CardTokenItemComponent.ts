import { injectable } from 'inversify';
import { Component } from './Component';

@injectable()
export class CardTokenItemComponent extends Component {
	element: HTMLElement;
	
	constructor() {
		super();
	}
	
	register( selector: string ) {
		const extraButton = this.element.querySelector( '.extra-button' );
		extraButton.addEventListener( 'click', () => {
			this.element.classList.add( 'extra-shown' );
		} );
		const closeButton = this.element.querySelector( '.close-button' );
		closeButton.addEventListener( 'click', () => {
			this.element.classList.remove( 'extra-shown' );
		} );
	}
}
