import '/resources/scss/admin.scss';
import App from './app';
import SettingsPage from './pages/admin/settings';
import ConnectionPage from './pages/admin/connection';
import WhitelistPage from './pages/admin/whitelist';

declare const wp: any;
declare const window: any;

const render = wp.element.render;

interface Redirect {
	from: string;
	to: string;
} 

class AdminApp extends App {
	pageElement: HTMLElement;
	view: string;
	props: object;
	
	constructor() {
		super();
		this.pageElement = document.querySelector( '.tokenpass-admin-page' );
		if ( this.pageElement ) {
			this.view = this.pageElement.dataset.view;
			this.props = JSON.parse( this.pageElement.dataset.props );
			const views = this.getViews();
			const ViewComponent = views[this.view];
			this.render( ViewComponent );
		}
	}
	
	getViews() {
		return {
			'settings':   SettingsPage,
			'connection': ConnectionPage,
			'whitelist':  WhitelistPage,
		} as any;
	}
	
	render( ViewComponent: any ) {
		if ( !this.pageElement ) {
			return;
		}
		const pageContainer = document.createElement( 'div' );
		this.pageElement.appendChild( pageContainer );
		render(
			<ViewComponent props={ this.props } />,
			pageContainer
		);
	}

	registerRedirects() {
		document.addEventListener('DOMContentLoaded', () => {
			if ( window['tokenpassRedirects'] ) {
				window['tokenpassRedirects'].forEach( ( redirect: Redirect ) => {
					const element: HTMLAnchorElement = document.querySelector(`[href='${redirect.from}']`);
					if (element) {
						element.href = redirect.to;
						element.target = '_blank';
					}
				});
			}
		})

	}
}

(function() {
	const admin = new AdminApp();
})();
