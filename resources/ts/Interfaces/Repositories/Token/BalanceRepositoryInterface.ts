export default interface BalanceRepositoryInterface {
	index( params: any ): Promise<Array<any>>
}
