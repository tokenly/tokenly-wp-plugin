import Component from '../Component'
import ItemCardComponentInterface from '../../Interfaces/Components/Token/ItemCardComponentInterface'

import { injectable } from 'inversify'

@injectable()
export default class ItemCardComponent extends Component implements ItemCardComponentInterface {
	constructor() {
		super()
	}
	
	register( selector: string ) {
		// const cardElement = this.element.querySelector( '.item-content' )
		// cardElement.addEventListener( 'click', () => {
		// 	this.element.classList.add( 'extra-shown' )
		// } )
		// const closeButton = this.element.querySelector( '.close-button' )
		// if ( closeButton ) {
		// 	closeButton.addEventListener( 'click', ( event ) => {
		// 		event.stopPropagation()
		// 		this.element.classList.remove( 'extra-shown' )
		// 	} )
		// }
		// const extraContainer = this.element.querySelector( '.extra-container' )
		// if ( extraContainer ) {
		// 	extraContainer.addEventListener( 'click', (event) => {
		// 		event.stopPropagation() 
		// 		this.element.classList.remove( 'extra-shown' )
		// 	} )
		// 	const extraContent = extraContainer.querySelector( '.extra-content' )
		// 	if ( extraContent ) {
		// 		extraContent.addEventListener( 'click', (event) => {
		// 			event.stopPropagation() 
		// 		} )
		// 	}
		// }
	}
}
