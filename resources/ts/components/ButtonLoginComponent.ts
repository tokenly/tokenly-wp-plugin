import { injectable, inject } from 'inversify';
import { Component } from '../Interfaces';
import { AuthService } from '../services/AuthService';

@injectable()
export class ButtonLoginComponent implements Component {
	authService: AuthService;
	element: HTMLElement;
	
	constructor(
		@inject( AuthService ) authService: AuthService,
	) {
		this.authService = authService;
	}
	
	register( selector: string ) {
		this.element.addEventListener( 'click', () => {
			this.authService.connect();
		} );
	}
}
