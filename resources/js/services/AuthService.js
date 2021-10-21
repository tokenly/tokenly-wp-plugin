class AuthService {
	namespace = '/wp-json/tokenly/v1/';
	
	constructor() {
		//
	}
	
	getStatus() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'GET',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = this.namespace + 'authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					resolve( data );
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	connect() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'POST',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = this.namespace + 'authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					const redirectUrl = data.url ?? null;
					if ( redirectUrl ) {
						window.location = redirectUrl;
					}
				} )
				.catch( err => reject( err ) );
		} );
	}
	
	disconnect() {
		return new Promise( ( resolve, reject ) => {
			const params = {
				method: 'DELETE',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = this.namespace + 'authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					window.location.reload( false );
				} )
				.catch( err => reject( err ) );
		});
	}
}