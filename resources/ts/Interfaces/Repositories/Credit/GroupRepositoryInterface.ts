export default interface GroupRepositoryInterface {
	index( params?: any ): Promise<Array<any>>;
	store( params: any ): Promise<any>;
	update( params: any ): Promise<any>;
}
