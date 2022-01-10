import { injectable } from 'inversify';
import {
	SourceData,
	UserShowParams,
	UserIndexParams,
	TokenMetaData,
	PromiseStoreParams,
	PromiseUpdateParams,
	PromiseData,
} from '../Interfaces';
import AdminApiServiceInterface from './../Interfaces/Services/AdminApiServiceInterface';

declare const window: any;

@injectable()
export default class AdminApiService implements AdminApiServiceInterface {
	namespace = '/wp-json/tokenly/v1';

	get headers() {
		return {
			'Content-type': 'application/json; charset=UTF-8',
			'X-WP-Nonce': window?.tokenpassData?.props?.nonce,
		}
	}
	
	settingsShow( type: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/settings/${type}` ).then( ( result: any ) => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	settingsUpdate( type: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/settings/${type}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	creditGroupIndex( params: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/credit/group', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	creditGroupShow( uuid: string, params: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/credit/group/${uuid}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	creditGroupStore( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/credit/group', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	creditGroupUpdate( uuid: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/credit/group/${uuid}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	creditTransactionIndex( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/credit/transaction', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	creditTransactionStore( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/credit/transaction', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenAddressIndex( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/address', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenAddressShow( id: string, params: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/address/${id}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenBalanceIndex( params: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/balance', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenMetaShow( postId: number ): Promise<TokenMetaData> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/meta/${postId}` ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenMetaUpdate( postId: number, params: TokenMetaData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/meta/${postId}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenPromiseIndex( params: any = {} ): Promise<Array<PromiseData>> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/promise', params ).then( ( result: Array<PromiseData> ) => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenPromiseShow( id: number, params: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/promise/${id}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenPromiseStore( params: PromiseStoreParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/token/promise', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenPromiseUpdate( promiseId: number, params: PromiseUpdateParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', `/token/promise/${promiseId}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenPromiseDestroy( promiseId: number ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'DELETE', `/token/promise/${promiseId}` ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenSourceIndex( params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/token/source', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenSourceShow( id: string, params: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/token/source/${id}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenSourceStore( params: SourceData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'POST', '/token/source', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenSourceUpdate( address: string, params: SourceData ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'PUT', '/token/source/' + address, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	tokenSourceDestroy( address: string ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'DELETE', '/token/source/' + address ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	userIndex( params: UserIndexParams ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', '/user', params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	userShow( id: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	userCreditBalanceIndex( id: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/credit/balance`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	userTokenBalanceIndex( id: string, params: any ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.makeRequest( 'GET', `/user/${id}/token/balance`, params ).then( result => {
				resolve( result );
			}).catch( error => {
				reject( error );
			} );
		});
	}

	makeRequest( method: string = '', route: string = '', args: any = {} ): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			const params: RequestInit = {
				method: method,
				headers: this.headers,
			};
			const withBody = ['POST', 'PUT', 'UPDATE'];
			let url = `${this.namespace}${route}`;
			if ( withBody.includes( method ) ) {
				params.body = JSON.stringify( args );
			} else {
				const queryParams = new URLSearchParams( args as any );
				url = `${url}? + ${queryParams}`;
			}
			fetch( url, params )
				.then( response => response.json() )
				.then( ( data ) => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		});
	}
}
