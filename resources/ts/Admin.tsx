import { container } from "./Inversify.config";
import './../scss/Admin.scss';
import { Provider } from 'inversify-react';
import * as React from 'react';
import App from './App';
import AppLayout from './Layouts/AppLayout';
import SettingsPage from './Admin/Pages/SettingsPage';
import VendorPage from './Admin/Pages/VendorPage';
import BalancesShowPage from './Admin/Pages/BalancesShowPage';
import ConnectionPage from './Admin/Pages/ConnectionPage';
import WhitelistPage from './Admin/Pages/WhitelistPage';
import PromiseShowPage from './Admin/Pages/PromiseShowPage';
import PromiseStorePage from './Admin/Pages/PromiseStorePage';
import PromiseEditPage from './Admin/Pages/PromiseEditPage';
import SourceIndexPage from './Admin/Pages/SourceIndexPage';
import SourceShowPage from './Admin/Pages/SourceShowPage';
import SourceStorePage from './Admin/Pages/SourceStorePage';
import SourceEditPage from './Admin/Pages/SourceEditPage';
import DashboardPage from './Admin/Pages/DashboardPage';
import PostEditPage from './Admin/Pages/PostEditPage';
import TokenMetaEditPage from './Admin/Pages/TokenMetaEditPage';
import TcaRuleEditor from './Admin/Components/TcaRuleEditor';
import { Redirect } from './Interfaces';

declare const document: any;
declare const window: any;

import { 
	render,
} from '@wordpress/element';

class AdminApp extends App {
	container = container;
	pageElement: any;
	view: string;
	pageData: object;
	useTCA: boolean;
	postData: any;
	
	constructor() {
		super();
		this.pageElement = document.querySelector( '.tokenpass-admin-page' );
		if ( this.pageElement ) {
			const data = window.tokenpassData;
			if ( !data ) {
				return;
			}
			this.view = data?.view;
			this.pageData = data?.props;
			this.useTCA = data.useTCA;
			const views = this.getViews();
			const ViewComponent = views[ this.view ] ?? null;
			if ( ViewComponent ) {
				this.highlightMenu();
				this.render( ViewComponent );
			}
		}
		this.registerRedirects();
	}
	
	getViews() {
		return {
			'balances-show'   : BalancesShowPage,
			'settings'        : SettingsPage,
			'connection'      : ConnectionPage,
			'vendor'          : VendorPage,
			'whitelist'       : WhitelistPage,
			'promise-show'    : PromiseShowPage,
			'promise-store'   : PromiseStorePage,
			'promise-edit'    : PromiseEditPage,
			'source-index'    : SourceIndexPage,
			'source-show'     : SourceShowPage,
			'source-store'    : SourceStorePage,
			'source-edit'     : SourceEditPage,
			'post-edit'       : PostEditPage,
			'token-meta-edit' : TokenMetaEditPage,
			'dashboard'       : DashboardPage,
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
				<AppLayout>
					<ViewComponent pageData={ this.pageData } />
					{ this.useTCA == true &&
						<TcaRuleEditor />
					}
				</AppLayout>
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
	
	highlightMenu() {
		const adminMenu = document.querySelector( '#adminmenu #toplevel_page_tokenpass' );
		adminMenu.classList.remove( 'wp-not-current-submenu' );
		adminMenu.classList.add( 'wp-has-current-submenu', 'wp-menu-open' );
	}
}

( function() {
	const admin = new AdminApp();
} )();
