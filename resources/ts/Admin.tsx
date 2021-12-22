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
import CreditGroupIndexPage from './Admin/Pages/CreditGroupIndexPage';
import CreditGroupShowPage from './Admin/Pages/CreditGroupShowPage';
import CreditGroupStorePage from './Admin/Pages/CreditGroupStorePage';
import CreditGroupEditPage from './Admin/Pages/CreditGroupEditPage';
import CreditTransactionIndexPage from './Admin/Pages/CreditTransactionIndexPage';
import CreditTransactionStorePage from './Admin/Pages/CreditTransactionStorePage';
import SourceIndexPage from './Admin/Pages/SourceIndexPage';
import SourceShowPage from './Admin/Pages/SourceShowPage';
import SourceStorePage from './Admin/Pages/SourceStorePage';
import SourceEditPage from './Admin/Pages/SourceEditPage';
import DashboardPage from './Admin/Pages/DashboardPage';
import PostEditPage from './Admin/Pages/PostEditPage';
import TaxonomyEditPage from './Admin/Pages/TaxonomyEditPage';
import TokenMetaEditPage from './Admin/Pages/TokenMetaEditPage';

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
			'balances-show'             : BalancesShowPage,
			'settings'                  : SettingsPage,
			'connection'                : ConnectionPage,
			'vendor'                    : VendorPage,
			'whitelist'                 : WhitelistPage,
			'promise-show'              : PromiseShowPage,
			'promise-store'             : PromiseStorePage,
			'promise-edit'              : PromiseEditPage,
			'credit-group-index'        : CreditGroupIndexPage,
			'credit-group-show'         : CreditGroupShowPage,
			'credit-group-store'        : CreditGroupStorePage,
			'credit-group-edit'         : CreditGroupEditPage,
			'credit-transaction-index'  : CreditTransactionIndexPage,
			'credit-transaction-store'  : CreditTransactionStorePage,
			'source-index'              : SourceIndexPage,
			'source-show'               : SourceShowPage,
			'source-store'              : SourceStorePage,
			'source-edit'               : SourceEditPage,
			'post-edit'                 : PostEditPage,
			'taxonomy-edit'             : TaxonomyEditPage,
			'token-meta-edit'           : TokenMetaEditPage,
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
			'tokenly-vendor': [
				'balances-show',
				'promise-show',
				'promise-store',
				'promise-edit',
				'source-index',
				'source-show',
				'source-store',
				'source-edit',
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
