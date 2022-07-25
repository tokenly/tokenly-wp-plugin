import UserRepositoryInterface
	from '../Interfaces/Repositories/UserRepositoryInterface'

import { injectable, inject } from 'inversify'
import { TYPES } from '../Types'
import {
	ApiServiceInterface,
	UserIndexParamsInterface,
	UserShowParamsInterface,
	UserCreditBalanceIndexParamsInterface,
	UserTokenBalanceIndexParamsInterface,
	UserTokenAddressIndexParamsInterface,
} from '../Interfaces/Services/ApiServiceInterface'
import UserInterface from '../Interfaces/Models/UserInterface'
import User from '../Models/User'
import UserCollection from '../Collections/UserCollection'
import UserCollectionInterface
	from '../Interfaces/Collections/UserCollectionInterface'
import Account from '../Models/Credit/Account'
import AccountInterface from '../Interfaces/Models/Credit/AccountInterface'
import BalanceCollection from '../Collections/Token/BalanceCollection'
import Balance from '../Models/Token/Balance'
import BalanceInterface from '../Interfaces/Models/Token/BalanceInterface'
import BalanceCollectionInterface
	from '../Interfaces/Collections/Token/BalanceCollectionInterface'
import AccountCollection from '../Collections/Credit/AccountCollection'
import AddressCollectionInterface
	from '../Interfaces/Collections/Token/AddressCollectionInterface'
import AddressCollection from '../Collections/Token/AddressCollection'

@injectable()
export default class UserRepository implements UserRepositoryInterface {
	protected ApiService: ApiServiceInterface

	constructor(
		@inject(
			TYPES.Services.ApiServiceInterface
		) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService
	}
	
	public index(
		params?: UserIndexParamsInterface
	): Promise<UserCollectionInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userIndex( params ).then( ( result: any ) => {
				result = ( new UserCollection() ).fromJson( result )
				resolve( result )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public show(
		id: string, params?: UserShowParamsInterface
	): Promise<UserInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userShow(
				id, params
			).then( ( result: any ) => {
				result = ( new User() ).fromJson( result )
				resolve( result )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public creditBalanceIndex(
		id: string, params: UserCreditBalanceIndexParamsInterface
	): Promise<AccountCollection> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userCreditBalanceIndex(
				id, params
			).then( result => {
				const collection =
					( new AccountCollection() ).fromJson( result )
				resolve( collection )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public creditBalanceShow(
		id: string, group: string
	): Promise<AccountInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userCreditBalanceShow(
				id, group
			).then( result => {
				const account = ( new Account() ).fromJson( result )
				resolve( account )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public tokenBalanceIndex(
		id: string, params?: UserTokenBalanceIndexParamsInterface
	): Promise<BalanceCollectionInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userTokenBalanceIndex(
				id, params
			).then( result => {
				const collection =
					( new BalanceCollection() ).fromJson( result )
				resolve( collection )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public tokenBalanceShow(
		id: string, asset: string
	): Promise<BalanceInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userTokenBalanceShow(
				id, asset
			).then( result => {
				let balance = null
				if ( result ) {
					balance = ( new Balance() ).fromJson( result )
				}
				resolve( balance )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public tokenAddressIndex(
		id: string, params?: UserTokenAddressIndexParamsInterface
	): Promise<AddressCollectionInterface> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.userTokenAddressIndex(
				id, params
			).then( result => {
				const collection =
					( new AddressCollection() ).fromJson( result )
				resolve( collection )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}
}
