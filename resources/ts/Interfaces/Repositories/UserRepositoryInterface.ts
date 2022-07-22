import {
	UserIndexParamsInterface,
	UserShowParamsInterface,
	UserCreditBalanceIndexParamsInterface,
	UserTokenBalanceIndexParamsInterface,
	UserTokenAddressIndexParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface'

export default interface UserRepositoryInterface {
	index( params: UserIndexParamsInterface ): Promise<any>
	show( id: string, params?: UserShowParamsInterface ): Promise<any>
	creditBalanceIndex( id: string, params?: UserCreditBalanceIndexParamsInterface ): Promise<any>
	creditBalanceShow( id: string, group: string ): Promise<any>
	tokenAddressIndex( id: string, params?: UserTokenAddressIndexParamsInterface ): Promise<any>
	tokenBalanceIndex( id: string, params?: UserTokenBalanceIndexParamsInterface ): Promise<any>
	tokenBalanceShow( id: string, asset: string ): Promise<any>
}
