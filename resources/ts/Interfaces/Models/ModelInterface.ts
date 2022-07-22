export default interface ModelInterface {
	fill( data?: object ): this
	fromJson( data?: object ): this
	toJson(): object
	clone(): ModelInterface
}