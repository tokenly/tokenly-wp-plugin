export default interface AddressRepositoryInterface {
	index( params?: any ): Promise<Array<any>>
}
