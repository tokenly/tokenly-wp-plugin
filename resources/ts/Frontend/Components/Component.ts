import { injectable } from 'inversify'
import ComponentInterface from '../Interfaces/Components/ComponentInterface'

@injectable()
export default class Component implements ComponentInterface {
	public element: HTMLElement

	constructor() {
		//
	}

	register( selector: string ) {
		//
	}
}
