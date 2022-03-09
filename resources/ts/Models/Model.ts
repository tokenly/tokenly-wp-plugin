import ModelInterface from '../Interfaces/Models/ModelInterface';

export default class Model implements ModelInterface {
	[ key: string ]: any;

	constructor( data: object = {} ) {
		this.fill( data );
	}

	public fill( data: any = {} ): this {
		Object.keys( data ).forEach( ( key: string ) => {
			if ( this.fillable.includes( key ) ) {
				this[ key ] = data[ key ];
			}
		} );
		return this;
	}

	public toJson(): object {
		return {};
	}

	public fromJson( data: object = {} ): this {
		this.fill( data );
		return this;
	}

	protected get fillable(): Array<string> {
		return [];
	}
}