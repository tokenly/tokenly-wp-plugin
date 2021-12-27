export default interface TransactionRepositoryInterface {
	index( params: any ): Promise<Array<any>>;
	store( params: any ): Promise<any>;
}
