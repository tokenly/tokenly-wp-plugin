import CollectionInterface from '../Interfaces/Collections/CollectionInterface';
import Model from '../Models/Model';

export default class Collection extends Map implements CollectionInterface {
    protected class = Model;

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
}