import { container } from "./Inversify.config";
import './../scss/Admin.scss';
import { Provider } from 'inversify-react';
import * as React from 'react';
import App from './App';
import AppLayout from './Layouts/AppLayout';
import SettingsPage from './Admin/Pages/SettingsPage';
import VendorPage from './Admin/Pages/VendorPage';
import ConnectionPage from './Admin/Pages/ConnectionPage';
import CreditGroupIndexPage from './Admin/Pages/Credit/GroupIndexPage';
import CreditGroupShowPage from './Admin/Pages/Credit/GroupShowPage';
import CreditGroupStorePage from './Admin/Pages/Credit/GroupStorePage';
import CreditGroupEditPage from './Admin/Pages/Credit/GroupEditPage';
import CreditTransactionIndexPage from './Admin/Pages/Credit/TransactionIndexPage';
import CreditTransactionStorePage from './Admin/Pages/Credit/TransactionStorePage';
import TokenBalanceIndexPage from './Admin/Pages/Token/BalanceIndexPage';
import TokenPromiseShowPage from './Admin/Pages/Token/PromiseShowPage';
import TokenPromiseStorePage from './Admin/Pages/Token/PromiseStorePage';
import TokenPromiseEditPage from './Admin/Pages/Token/PromiseEditPage';
import TokenSourceIndexPage from './Admin/Pages/Token/SourceIndexPage';
import TokenSourceShowPage from './Admin/Pages/Token/SourceShowPage';
import TokenSourceStorePage from './Admin/Pages/Token/SourceStorePage';
import TokenSourceEditPage from './Admin/Pages/Token/SourceEditPage';
import TaxonomyEditPage from './Admin/Pages/TaxonomyEditPage';
import TokenMetaEditPage from './Admin/Pages/TokenMetaEditPage';
import DashboardPage from './Admin/Pages/DashboardPage';
import PostEditPage from './Admin/Pages/PostEditPage';
import WhitelistPage from './Admin/Pages/WhitelistPage';
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
	pageData: any;
	tcaEnabled: boolean = false;
	tcaRules: any = [];
	routePrefix: string = 'tokenly';
	post: number;
	action: string;

	constructor() {
		super();
		this.pageElement = document.querySelector( '.tokenpass-admin-page' );
		if ( this.pageElement ) {
			const data = window.tokenpassData;
			if ( !data ) {
				return;
			}
			this.pageData = data?.props;
			this.view = this.pageData?.view;
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
		let routes = {
			'dashboard'                 : DashboardPage,
			'settings'                  : SettingsPage,
			'connection'                : ConnectionPage,
			'credit-group-index'        : CreditGroupIndexPage,
			'credit-group-show'         : CreditGroupShowPage,
			'credit-group-store'        : CreditGroupStorePage,
			'credit-group-edit'         : CreditGroupEditPage,
			'credit-transaction-index'  : CreditTransactionIndexPage,
			'credit-transaction-store'  : CreditTransactionStorePage,
			'token-balance-index'       : TokenBalanceIndexPage,
			'token-promise-show'        : TokenPromiseShowPage,
			'token-promise-store'       : TokenPromiseStorePage,
			'token-promise-edit'        : TokenPromiseEditPage,
			'token-source-index'        : TokenSourceIndexPage,
			'token-source-show'         : TokenSourceShowPage,
			'token-source-store'        : TokenSourceStorePage,
			'token-source-edit'         : TokenSourceEditPage,
			'token-meta-edit'           : TokenMetaEditPage,
			'token-vendor'              : VendorPage,
			'token-whitelist-edit'      : WhitelistPage,
			'post-edit'                 : PostEditPage,
			'taxonomy-edit'             : TaxonomyEditPage,

		} as any;
		return routes;
	}

	getRedirects() {
		const redirects = [
			{
				from: 'tokenly-inventory',
				to: '/tokenly/user/me',
			},
			{
				from: 'tokenly-dashboard',
				to: 'https://tokenpass.tokenly.com/dashboard',
			},
		];
		return redirects;
	}

	getHighlights() {
		const highlights = {
			'tokenly-token-vendor': [
				'token-balance-index',
				'token-promise-show',
				'token-promise-store',
				'token-promise-edit',
				'token-source-index',
				'token-source-show',
				'token-source-store',
				'token-source-edit',
			],
			'tokenly-credit-group-index': [
				'credit-group-index',
				'credit-group-show',
				'credit-group-store',
				'credit-group-edit',
				'credit-transaction-index',
				'credit-transaction-store',
			],
		} as any;
		return highlights;
	}
	
	render( ViewComponent: any ) {
		if ( !this.pageElement ) {
			return;
		}
		const pageContainer = document.createElement( 'div' );
		this.pageElement.appendChild( pageContainer );
		render(
			<Provider container={ this.container }>
				<AppLayout pageData={ this.pageData }>
					<ViewComponent pageData={ this.pageData } />
				</AppLayout>
			</Provider>,
			pageContainer
		);
	}

	registerRedirects() {
		const redirects = this.getRedirects();
		document.addEventListener( 'DOMContentLoaded', () => {
			redirects.forEach( ( redirect: Redirect ) => {
				const element: any = document.querySelector( `[href='${redirect.from}']` );
				if ( element ) {
					element.href = redirect.to;
					element.target = '_blank';
				}
			} );
		} );
	}
	
	highlightMenu() {
		const adminMenu = document.querySelector( '#adminmenu #toplevel_page_tokenly' );
		if ( !adminMenu ) {
			return;
		}
		adminMenu.classList.remove( 'wp-not-current-submenu' );
		adminMenu.classList.add( 'wp-has-current-submenu', 'wp-menu-open' );
		const highlights = this.getHighlights();
		const view = this.view;
		Object.keys( highlights ).forEach( key => {
			const selector = `a[href='admin.php?page=${key}']`;
			let menuItemElement = adminMenu.querySelector( selector );
			if ( menuItemElement ) {
				menuItemElement = menuItemElement.closest( 'li' );
				if ( highlights[key].includes( view ) ) {
					menuItemElement.classList.add( 'current' );
				}
			}
		} );
	}
}

( function() {
	const admin = new AdminApp();
} )();
