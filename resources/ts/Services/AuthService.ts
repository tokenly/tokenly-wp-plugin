import AuthServiceInterface from '../Interfaces/Services/AuthServiceInterface'

import { injectable, inject } from 'inversify'
import { TYPES } from '../Types'
import { ApiServiceInterface } from '../Interfaces/Services/ApiServiceInterface'

@injectable()
export default class AuthService implements AuthServiceInterface {
	protected ApiService: ApiServiceInterface

	constructor(
		@inject(
			TYPES.Services.ApiServiceInterface
		) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService
	}
	
	public getStatus(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.authGetStatus().then( ( result: any ) => {
				resolve( result )
			} ).catch( ( error: any ) => {
				reject( error )
			} )
		} )
	}
	
	public connect(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.authConnect().then( ( result: any ) => {
				resolve( result )
			} ).catch( ( error: any ) => {
				reject( error )
			} )
		} )
	}
	
	public disconnect(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.ApiService.authDisconnect().then( ( result: any ) => {
				resolve( result )
			} ).catch( ( error: any ) => {
				reject( error )
			} )
		} )
	}
}
