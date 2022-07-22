import CollectionInterface from '../Interfaces/Collections/CollectionInterface'
import Model from '../Models/Model'

export default class Collection extends Map implements CollectionInterface {
    protected class = Model

    constructor() {
        super()
    }

    public fromJson( data: any ): this {
        if ( Array.isArray( data ) ) {
            data.forEach( ( item, key ) => {
                const value = ( new this.class() ).fromJson( item )
                this.set( key, value )
            } )
        } else if ( typeof data === 'object' ) {
            Object.keys( data ).forEach( ( key ) => {
                const value = ( new this.class() ).fromJson( data[ key ] )
                this.set( key, value )
            } )
        }
        return this
    }

    public toJson(): any {
        const copy = this.clone()
        copy.forEach( ( item, key: string ) => {
            copy.set( key, item.toJson() )
        } )
        const object = Object.fromEntries(copy)
        return object
    }

    public clone(): CollectionInterface {
        let clone: any = Object.assign( new ( <typeof Collection>this.constructor ), this )
        this.forEach( ( item, key: string ) => {
            clone.set( key, item.clone() )
        } )
        return clone
    }

    public keyByField( field: string ): CollectionInterface {
        const keyed = new ( <typeof Collection>this.constructor )
        this.forEach( ( item: any, key: any ) => {
            keyed.set( item[ field ], item )
        } )
        return keyed
    }

    public toSequential(): CollectionInterface {
        const sequential: CollectionInterface =
            new ( <typeof Collection>this.constructor )
        console.log(sequential)
        let i: number = 0
        this.forEach( ( item, key: string ) => {
            sequential.set( i, item.clone() )
            i++
        } )
        return sequential
    }
}