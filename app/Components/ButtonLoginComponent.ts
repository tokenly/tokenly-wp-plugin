export class ButtonLoginComponent {
	constructor() {
		// this.buttonElement = buttonElement;
		// this.buttonElement.addEventListener( 'click', this.connect.bind( this ) );
	}
}

export function init() {
	const buttonElements = document.querySelectorAll('button.tokenpass-login');
	console.log(buttonElements);
	buttonElements.forEach( ( buttonElement ) => {
		// buttonElement = new ButtonLoginComponent( buttonElement );
	} );
}