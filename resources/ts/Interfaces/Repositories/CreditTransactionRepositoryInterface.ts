export interface CreditTransactionRepositoryInterface {
	index(): Promise<Array<any>>;
	store( params: any ): Promise<any>;
}
