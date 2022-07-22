import {
	TokenAddressIndexParamsInterface,
	TokenAddressBalanceIndexParamsInterface,
	TokenAddressShowParamsInterface,
	TokenAddressStoreParamsInterface,
	TokenAddressUpdateParamsInterface,
	TokenAddressVerifyParamsInterface,
} from '../../../Interfaces/Services/ApiServiceInterface'
import AddressInterface from '../../Models/Token/AddressInterface'
import AddressCollectionInterface from '../../Collections/Token/AddressCollectionInterface'
import BalanceCollectionInterface from '../../Collections/Token/BalanceCollectionInterface'

export default interface AddressRepositoryInterface {
	index( params?: TokenAddressIndexParamsInterface ): Promise<AddressCollectionInterface>
	show( id: string, params?: TokenAddressShowParamsInterface ): Promise<AddressInterface>
	store( params: TokenAddressStoreParamsInterface ): Promise<Array<any>>
	update( id: string, params: TokenAddressUpdateParamsInterface ): Promise<Array<any>>
	destroy( id: string ): Promise<Array<any>>
	verify( id: string, params: TokenAddressVerifyParamsInterface ): Promise<Array<any>>
	balanceIndex( id: string, params?: TokenAddressBalanceIndexParamsInterface ): Promise<BalanceCollectionInterface>
}
