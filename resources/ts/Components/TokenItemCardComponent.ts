import { injectable } from 'inversify';
import { Component } from './Component';

@injectable()
export class TokenItemCardComponent extends Component {
	element: HTMLElement;
	
	constructor() {
		super();
	}
	
	register( selector: string ) {
		const extraButton = this.element.querySelector( '.extra-button' );
		if ( extraButton ) {
			extraButton.addEventListener( 'click', () => {
				this.element.classList.add( 'extra-shown' );
			} );
		}
		const closeButton = this.element.querySelector( '.close-button' );
		if ( closeButton ) {
			closeButton.addEventListener( 'click', () => {
				this.element.classList.remove( 'extra-shown' );
			} );
		}
	}
}
