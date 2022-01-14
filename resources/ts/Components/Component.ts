import { injectable } from 'inversify';
import ComponentInterface from './../Interfaces/Components/ComponentInterface';

@injectable()
export default class Component implements ComponentInterface {
	constructor() {
		//
	}

	register( selector: string ) {
		//
	}
}
