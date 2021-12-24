export default interface TransactionRepositoryInterface {
	index(): Promise<Array<any>>;
	store( params: any ): Promise<any>;
}
