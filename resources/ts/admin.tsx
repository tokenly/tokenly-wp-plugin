import { container } from "./inversify.config";
import '/resources/scss/admin.scss';
import { Provider } from 'inversify-react';
import * as React from 'react';
import App from './app';
import SettingsPage from './admin/pages/SettingsPage';
import VendorPage from './admin/pages/VendorPage';
import ConnectionPage from './admin/pages/ConnectionPage';
import WhitelistPage from './admin/pages/WhitelistPage';

declare const wp: any;
declare const document: any;
declare const window: any;

const render = wp.element.render;

interface Redirect {
	from: string;
	to: string;
} 

class AdminApp extends App {
	container = container;
	pageElement: any;
	view: string;
	pageData: object;
	
	constructor() {
		super();
		this.pageElement = document.querySelector( '.tokenpass-admin-page' );
		if ( this.pageElement ) {
			this.view = this.pageElement.dataset.view;
			this.pageData = JSON.parse( this.pageElement.dataset.props );
			const views = this.getViews();
			const ViewComponent = views[ this.view ];
			this.render( ViewComponent );
		}
		this.registerRedirects();
	}
	
	getViews() {
		return {
			'settings':   SettingsPage,
			'connection': ConnectionPage,
			'vendor':  VendorPage,
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
			<Provider container={ this.container }>
				<ViewComponent pageData={ this.pageData } />
			</Provider>,
			pageContainer
		);
	}

	registerRedirects() {
		document.addEventListener( 'DOMContentLoaded', () => {
			if ( window['tokenpassRedirects'] ) {
				window['tokenpassRedirects'].forEach( ( redirect: Redirect ) => {
					const element: any = document.querySelector( `[href='${redirect.from}']` );
					if ( element ) {
						element.href = redirect.to;
						element.target = '_blank';
					}
				} );
			}
		})

	}
}

( function() {
	const admin = new AdminApp();
} )();
