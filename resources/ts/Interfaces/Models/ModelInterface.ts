export default interface Model {
	fill( data?: object ): this;
	fromJson( data?: object ): this;
	toJson(): object;
}