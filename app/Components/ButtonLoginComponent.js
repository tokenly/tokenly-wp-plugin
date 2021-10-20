class ButtonLoginComponent {
	constructor( buttonElement ) {
		this.buttonElement = buttonElement;
		this.buttonElement.addEventListener( 'click', this.connect.bind( this ) );
	}

	connect() {
		console.log('click');
		return new Promise((resolve, reject) => {
			const params = {
				method: 'POST',
				headers: {
					'Content-type': 'application/json; charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
			}
			const url = '/wp-json/tokenly/v1/authorize';
			fetch( url, params )
				.then( response => response.json() )
				.then( data => {
					console.log(data);
					const redirectUrl = data.url ?? null;
					if (redirectUrl) {
						window.location = redirectUrl;
					}	
					resolve( data );
				} )
				.catch( err => {
					console.log(err);
					reject( err )
				 } );
		});
	}
}

export function init() {
	const buttonElements = document.querySelectorAll('button.tokenpass-login');
	console.log(buttonElements);
	buttonElements.forEach( ( buttonElement ) => {
		buttonElement = new ButtonLoginComponent( buttonElement );
	} );
}