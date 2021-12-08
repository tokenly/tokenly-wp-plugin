export interface CreditGroupRepositoryInterface {
	index(): Promise<Array<any>>;
	store( params: any ): Promise<any>;
	update( params: any ): Promise<any>;
}
