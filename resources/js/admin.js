import '/resources/scss/admin.scss';
import App from '/resources/js/app.js';
import SettingsPage from '/resources/js/pages/admin/settings.js';
import ConnectionPage from '/resources/js/pages/admin/connection.js';
import WhitelistPage from '/resources/js/pages/admin/whitelist.js';

const render = wp.element.render;

class AdminApp extends App {
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
			settings:   SettingsPage,
			connection: ConnectionPage,
			whitelist:  WhitelistPage,
		}
	}
	
	render( ViewComponent ) {
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
			if ( window?.tokenpassRedirects ) {
				window.tokenpassRedirects.forEach((redirect) => {
					const element = document.querySelector(`[href='${redirect.from}']`);
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
