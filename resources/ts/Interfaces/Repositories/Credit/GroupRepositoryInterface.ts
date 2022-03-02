export default interface GroupRepositoryInterface {
	index( params?: any ): Promise<Array<any>>;
	show( uuid: string, params?: any ): Promise<Array<any>>;
	store( params: any ): Promise<any>;
	update( uuid: string, params: any ): Promise<any>;
	whitelistUpdate( params: any ): Promise<any>;
	accountIndex( uuid: string, params?: any ): Promise<Array<any>>;
}
