import {
	TokenAddressIndexParamsInterface,
	TokenAddressBalanceIndexParamsInterface,
	TokenAddressShowParamsInterface,
	TokenAddressStoreParamsInterface,
	TokenAddressUpdateParamsInterface,
	TokenAddressVerifyParamsInterface,
} from './../../../Interfaces/Services/ApiServiceInterface';

export default interface AddressRepositoryInterface {
	index( params?: TokenAddressIndexParamsInterface ): Promise<Array<any>>
	show( id: string, params?: TokenAddressShowParamsInterface ): Promise<Array<any>>
	store( params: TokenAddressStoreParamsInterface ): Promise<Array<any>>
	update( id: string, params: TokenAddressUpdateParamsInterface ): Promise<Array<any>>
	destroy( id: string ): Promise<Array<any>>
	verify( id: string, params: TokenAddressVerifyParamsInterface ): Promise<Array<any>>
	balanceIndex( id: string, params?: TokenAddressBalanceIndexParamsInterface ): Promise<Array<any>>
}
