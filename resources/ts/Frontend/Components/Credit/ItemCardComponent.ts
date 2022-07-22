import { injectable } from 'inversify'
import Component from '../Component'
import ItemCardComponentInterface from '../../Interfaces/Components/Token/ItemCardComponentInterface'

@injectable()
export default class ItemCardComponent extends Component implements ItemCardComponentInterface {
	element: HTMLElement
	
	constructor() {
		super()
	}
	
	register( selector: string ) {
		//
	}
}
