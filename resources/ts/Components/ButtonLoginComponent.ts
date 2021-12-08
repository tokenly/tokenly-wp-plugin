import { injectable, inject } from 'inversify';
import { AuthServiceInterface } from '../Interfaces/Services/AuthServiceInterface';
import { TYPES } from './../Types';
import { Component } from './Component';

@injectable()
export class ButtonLoginComponent extends Component {
	authService: AuthServiceInterface;
	element: HTMLElement;
	
	constructor(
		@inject( TYPES.AuthServiceInterface ) authService: AuthServiceInterface,
	) {
		super();
		this.authService = authService;
	}
	
	register( selector: string ) {
		this.element.addEventListener( 'click', () => {
			this.element.classList.add( 'loading' );
		} );
	}
}
