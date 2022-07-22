import { injectable, inject } from 'inversify'
import AuthServiceInterface from '../../Interfaces/Services/AuthServiceInterface'
import LoginButtonComponentInterface from '../Interfaces/Components/LoginButtonComponentInterface'
import { TYPES } from '../../Types'
import Component from './Component'

@injectable()
export default class LoginButtonComponent extends Component implements LoginButtonComponentInterface {
	authService: AuthServiceInterface
	element: HTMLElement
	
	constructor(
		@inject( TYPES.Services.AuthServiceInterface ) authService: AuthServiceInterface,
	) {
		super()
		this.authService = authService
	}
	
	register( selector: string ) {
		const link = this.element.querySelector( 'a' )
		link.addEventListener( 'click', () => {
			link.classList.add( 'loading' )
		} )
	}
}
