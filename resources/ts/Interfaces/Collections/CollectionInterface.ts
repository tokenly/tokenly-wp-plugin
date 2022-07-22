export default interface CollectionInterface extends Map<any, any> {
    toJson(): any
    fromJson( data: any ): this
    clone(): CollectionInterface
}