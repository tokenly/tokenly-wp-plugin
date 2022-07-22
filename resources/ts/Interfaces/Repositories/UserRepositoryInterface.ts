import {
	UserIndexParamsInterface,
	UserShowParamsInterface,
	UserCreditBalanceIndexParamsInterface,
	UserTokenBalanceIndexParamsInterface,
	UserTokenAddressIndexParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface'
import AccountCollectionInterface from '../Collections/Credit/AccountCollectionInterface';
import AddressCollectionInterface from '../Collections/Token/AddressCollectionInterface';
import BalanceCollectionInterface from '../Collections/Token/BalanceCollectionInterface';
import AccountInterface from '../Models/Credit/AccountInterface';
import BalanceInterface from '../Models/Token/BalanceInterface';

export default interface UserRepositoryInterface {
	index( params: UserIndexParamsInterface ): Promise<any>
	show( id: string, params?: UserShowParamsInterface ): Promise<any>
	creditBalanceIndex(id: string, params?: UserCreditBalanceIndexParamsInterface ): Promise<AccountCollectionInterface>
	creditBalanceShow( id: string, group: string ): Promise<AccountInterface>
	tokenAddressIndex( id: string, params?: UserTokenAddressIndexParamsInterface ): Promise<AddressCollectionInterface>
	tokenBalanceIndex( id: string, params?: UserTokenBalanceIndexParamsInterface ): Promise<BalanceCollectionInterface>
	tokenBalanceShow( id: string, asset: string ): Promise<BalanceInterface>
}
