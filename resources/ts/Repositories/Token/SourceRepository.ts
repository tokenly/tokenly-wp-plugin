import SourceRepositoryInterface
	from '../../Interfaces/Repositories/Token/SourceRepositoryInterface'

import { injectable, inject } from 'inversify'
import { TYPES } from '../../Types'
import {
	ApiServiceInterface,
	TokenSourceIndexParamsInterface,
	TokenSourceShowParamsInterface,
	TokenSourceStoreParamsInterface,
	TokenSourceUpdateParamsInterface,
} from '../../Interfaces/Services/ApiServiceInterface'
import SourceInterface from '../../Interfaces/Models/Token/SourceInterface'
import Source from '../../Models/Token/Source'
import SourceCollectionInterface
	from '../../Interfaces/Collections/Token/SourceCollectionInterface'
import SourceCollection from '../../Collections/Token/SourceCollection'

@injectable()
export default class SourceRepository implements SourceRepositoryInterface {
	ApiService: ApiServiceInterface
	
	constructor(
		@inject(
			TYPES.Services.ApiServiceInterface
		) ApiService: ApiServiceInterface
	) {
		this.ApiService = ApiService
	}

	public index(
		params?: TokenSourceIndexParamsInterface
	): Promise<SourceCollectionInterface> {
		return new Promise<SourceCollectionInterface>( (
			resolve, reject
		) => {
			this.ApiService.tokenSourceIndex(
				params
			).then( ( result: any ) => {
				const collection =
					( new SourceCollection() ).fromJson( result )
				resolve( collection )
			} ).catch( error => {
				reject( error )
			} )
		})
	}

	public show(
		id: string, params?: TokenSourceShowParamsInterface
	): Promise<SourceInterface> {
		return new Promise<SourceInterface>( ( resolve, reject ) => {
			this.ApiService.tokenSourceShow(
				id, params
			).then( ( result: any ) => {
				let source = null
				if ( result ) {
					source = ( new Source() ).fromJson( result )
				}
				resolve( source )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public store( params: TokenSourceStoreParamsInterface ): Promise<any> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenSourceStore( params ).then( result => {
				resolve( result )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public update(
		address: string, params: TokenSourceUpdateParamsInterface
	): Promise<any> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenSourceUpdate(
				address, params
			).then( result => {
				resolve( result )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}

	public destroy( address: string ): Promise<any> {
		return new Promise<any>( ( resolve, reject ) => {
			this.ApiService.tokenSourceDestroy( address ).then( result => {
				resolve( result )
			} ).catch( error => {
				reject( error )
			} )
		} )
	}
}
