import { Provider } from 'inversify-react';
import { container } from "./../Inversify.config";
import * as React from 'react';
import { TYPES } from './../Types';
import { injectable, inject } from 'inversify';
import { Redirect } from './../Interfaces';
import { 
	render,
} from '@wordpress/element';
import AdminRouterInterface from './../Interfaces/Routes/AdminRouterInterface';
import AppLayout from './../Layouts/AppLayout';
import SettingsPage from './../Admin/Pages/SettingsPage';
import ConnectionPage from './../Admin/Pages/ConnectionPage';
import CreditGroupIndexPage from './../Admin/Pages/Credit/GroupIndexPage';
import CreditGroupShowPage from './../Admin/Pages/Credit/GroupShowPage';
import CreditGroupStorePage from './../Admin/Pages/Credit/GroupStorePage';
import CreditGroupEditPage from './../Admin/Pages/Credit/GroupEditPage';
import CreditTransactionIndexPage from './../Admin/Pages/Credit/TransactionIndexPage';
import CreditTransactionStorePage from './../Admin/Pages/Credit/TransactionStorePage';
import CreditVendorPage from './../Admin/Pages/Credit/VendorPage';
import TaxonomyEditPage from './../Admin/Pages/TaxonomyEditPage';
import UserCreditBalanceIndexPage from './../Admin/Pages/User/Credit/BalanceIndexPage';
import UserTokenBalanceIndexPage from './../Admin/Pages/User/Token/BalanceIndexPage';
import TokenPromiseShowPage from './../Admin/Pages/Token/PromiseShowPage';
import TokenPromiseStorePage from './../Admin/Pages/Token/PromiseStorePage';
import TokenPromiseEditPage from './../Admin/Pages/Token/PromiseEditPage';
import TokenSourceIndexPage from './../Admin/Pages/Token/SourceIndexPage';
import TokenSourceShowPage from './../Admin/Pages/Token/SourceShowPage';
import TokenSourceStorePage from './../Admin/Pages/Token/SourceStorePage';
import TokenSourceEditPage from './../Admin/Pages/Token/SourceEditPage';
import TokenMetaEditPage from './../Admin/Pages/Token/MetaEditPage';
import TokenVendorPage from './../Admin/Pages/Token/VendorPage';
import TokenWhitelistEditPage from './../Admin/Pages/Token/WhitelistEditPage';
import DashboardPage from './../Admin/Pages/DashboardPage';
import PostEditPage from './../Admin/Pages/PostEditPage';

declare const document: any;
declare const window: any;

@injectable()
export default class AdminRouter implements AdminRouterInterface {
	container = container;
	pageElement: any;
	view: string;
	pageData: any;
	post: number;
	namespace: string;

	constructor(
		@inject( TYPES.Variables.namespace ) namespace: string
	) {
		this.namespace = namespace;
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
			'credit-vendor'             : CreditVendorPage,
			'token-promise-show'        : TokenPromiseShowPage,
			'token-promise-store'       : TokenPromiseStorePage,
			'token-promise-edit'        : TokenPromiseEditPage,
			'token-source-index'        : TokenSourceIndexPage,
			'token-source-show'         : TokenSourceShowPage,
			'token-source-store'        : TokenSourceStorePage,
			'token-source-edit'         : TokenSourceEditPage,
			'token-meta-edit'           : TokenMetaEditPage,
			'token-vendor'              : TokenVendorPage,
			'token-whitelist-edit'      : TokenWhitelistEditPage,
			'user-token-balance-index'  : UserTokenBalanceIndexPage,
			'user-credit-balance-index' : UserCreditBalanceIndexPage,
			'post-edit'                 : PostEditPage,
			'taxonomy-edit'             : TaxonomyEditPage,

		} as any;
		return routes;
	}

	getRedirects() {
		const redirects = [
			{
				from: `${ this.namespace }-inventory`,
				to: `/${ this.namespace }/user/me`,
			},
			{
				from: `${ this.namespace }-dashboard`,
				to: 'https://tokenpass.tokenly.com/dashboard',
			},
		];
		return redirects;
	}

	getHighlights() {
		const highlights = {
			[`${ this.namespace }-token-vendor`]: [
				'token-promise-show',
				'token-promise-store',
				'token-promise-edit',
				'token-source-index',
				'token-source-show',
				'token-source-store',
				'token-source-edit',
				'token-meta-edit',
				'token-whitelist-edit',
			],
			[ `${ this.namespace }-credit-vendor` ]: [
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
