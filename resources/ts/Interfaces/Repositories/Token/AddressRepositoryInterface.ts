export default interface AddressRepositoryInterface {
	index( params?: any ): Promise<Array<any>>
	show( id: string, params?: any ): Promise<Array<any>>
	balanceIndex( id: string, params?: any ): Promise<Array<any>>
}
