export default interface CollectionInterface extends Map<string, any> {
    toJson(): any;
    fromJson( data: any ): this;
    clone(): CollectionInterface;
}