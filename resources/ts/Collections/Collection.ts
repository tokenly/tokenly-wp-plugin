import CollectionInterface from '../Interfaces/Collections/CollectionInterface';
import Model from '../Models/Model';

export default class Collection extends Map implements CollectionInterface {
    protected class = Model;

    constructor() {
        super();
    }

    public fromJson( data: any ): this {
        if ( Array.isArray( data ) ) {
            data.forEach( ( item, key ) => {
                const value = ( new this.class() ).fromJson( item );
                this.set( key, value );
            } )
        } else if ( typeof data === 'object' ) {
            Object.keys( data ).forEach( ( key ) => {
                const value = ( new this.class() ).fromJson( data[ key ] );
                this.set( key, value );
            } );
        }
        return this;
    }

    public toJson(): any {
        return {};
    }

    public clone(): CollectionInterface {
        let clone: any = Object.assign( new ( <typeof Collection>this.constructor ), this );
        this.forEach( ( item, key: string ) => {
            clone.set( key, item.clone() );
        } );
        return clone;
    }
}