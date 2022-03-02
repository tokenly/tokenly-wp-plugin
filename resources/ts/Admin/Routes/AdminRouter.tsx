import { Provider } from 'inversify-react';
import { container } from '../Inversify.config';
import * as React from 'react';
import { TYPES } from './../../Types';
import { injectable, inject } from 'inversify';
import { Redirect } from './../../Interfaces';
import { 
	render,
} from '@wordpress/element';
import AdminRouterInterface from './../Interfaces/Routes/AdminRouterInterface';
import AppLayout from './../Layouts/AppLayout';
import SettingsPage from './../Pages/SettingsPage';
import CreditGroupAccountIndexPage from './../Pages/Credit/GroupAccountIndexPage';
import CreditGroupIndexPage from './../Pages/Credit/GroupIndexPage';
import CreditGroupShowPage from './../Pages/Credit/GroupShowPage';
import CreditGroupStorePage from './../Pages/Credit/GroupStorePage';
import CreditGroupEditPage from './../Pages/Credit/GroupEditPage';
import CreditGroupWhitelistEditPage from './../Pages/Credit/GroupWhitelistEditPage';
import CreditTransactionIndexPage from './../Pages/Credit/TransactionIndexPage';
import CreditTransactionStorePage from './../Pages/Credit/TransactionStorePage';
import CreditVendorPage from './../Pages/Credit/VendorPage';
import TokenAddressIndexPage from './../Pages/Token/AddressIndexPage';
import TokenAddressShowPage from './../Pages/Token/AddressShowPage';
import TokenAddressStorePage from './../Pages/Token/AddressStorePage';
import TokenAddressEditPage from './../Pages/Token/AddressEditPage';
import TokenAddressVerifyPage from './../Pages/Token/AddressVerifyPage';
import TokenAddressBalanceIndexPage from './../Pages/Token/AddressBalanceIndexPage';
import TokenCategoryTermEditPage from './../Pages/Token/CategoryTermEditPage';
import TokenPromiseIndexPage from './../Pages/Token/PromiseIndexPage';
import TokenPromiseShowPage from './../Pages/Token/PromiseShowPage';
import TokenPromiseStorePage from './../Pages/Token/PromiseStorePage';
import TokenPromiseEditPage from './../Pages/Token/PromiseEditPage';
import TokenSourceIndexPage from './../Pages/Token/SourceIndexPage';
import TokenSourceShowPage from './../Pages/Token/SourceShowPage';
import TokenSourceStorePage from './../Pages/Token/SourceStorePage';
import TokenSourceEditPage from './../Pages/Token/SourceEditPage';
import TokenVendorPage from './../Pages/Token/VendorPage';
import TokenWhitelistEditPage from './../Pages/Token/WhitelistEditPage';
import UserShowPage from './../Pages/User/UserShowPage';
import UserCreditBalanceIndexPage from './../Pages/User/Credit/BalanceIndexPage';
import UserTokenBalanceIndexPage from './../Pages/User/Token/BalanceIndexPage';
import DashboardPage from './../Pages/DashboardPage';
import PostEditPage from './../Pages/PostEditPage';
import TermEditPage from './../Pages/TermEditPage';
import TokenMetaEditPage from './../Pages/Token/MetaEditPage';
import TokenMetaFeaturedImageColumn from './../Pages/Listings/Token/MetaFeaturedImageColumn';
import UserCreditBalanceColumn from './../Pages/Listings/User/UserCreditBalanceColumn';

declare const document: any;
declare const window: any;

@injectable()
export default class AdminRouter implements AdminRouterInterface {
	container = container;
	element: any;
	pageData: any;
	post: number;
	namespace: string;
	apiHost: string;

	constructor(
		@inject( TYPES.Variables.namespace ) namespace: string,
		@inject( TYPES.Variables.apiHost ) apiHost: string
	) {
		this.namespace = namespace;
		this.apiHost = apiHost;
		const views: any = this.getViews();
		const elements = document.querySelectorAll( `.${namespace}-admin-page` );
		elements.forEach( ( element: HTMLElement ) => {
			const view = element.dataset.view;
			const json = element.dataset.props.replace( /\\/g,"" );
			const props = JSON.parse( json );
			if ( props && views[ view ] ) {
				const ViewComponent = views[ view ];
				this.render( element, ViewComponent, props, view );
			}
		} );
		this.registerRedirects();
		this.highlightMenu();
		console.log( window?.tokenpassData );
	}

	/**
	 * Gets the view definitions
	 * @returns {object}
	 */
	protected getViews(): object {
		let routes = {
			'dashboard'                                                              : DashboardPage,
			'credit-group-account-index'                                             : CreditGroupAccountIndexPage,
			'credit-group-index'                                                     : CreditGroupIndexPage,
			'credit-group-show'                                                      : CreditGroupShowPage,
			'credit-group-store'                                                     : CreditGroupStorePage,
			'credit-group-edit'                                                      : CreditGroupEditPage,
			'credit-group-whitelist-edit'                                            : CreditGroupWhitelistEditPage,
			'credit-transaction-index'                                               : CreditTransactionIndexPage,
			'credit-transaction-store'                                               : CreditTransactionStorePage,
			'credit-vendor'                                                          : CreditVendorPage,
			'post-edit'                                                              : PostEditPage,
			'settings'                                                               : SettingsPage,
			'token-address-index'                                                    : TokenAddressIndexPage,
			'token-address-show'                                                     : TokenAddressShowPage,
			'token-address-store'                                                    : TokenAddressStorePage,
			'token-address-edit'                                                     : TokenAddressEditPage,
			'token-address-verify'                                                   : TokenAddressVerifyPage,
			'token-address-balance-index'                                            : TokenAddressBalanceIndexPage,
			'token-category-term-edit'                                               : TokenCategoryTermEditPage,
			'token-promise-index'                                                    : TokenPromiseIndexPage,
			'token-promise-show'                                                     : TokenPromiseShowPage,
			'token-promise-store'                                                    : TokenPromiseStorePage,
			'token-promise-edit'                                                     : TokenPromiseEditPage,
			'token-source-index'                                                     : TokenSourceIndexPage,
			'token-source-show'                                                      : TokenSourceShowPage,
			'token-source-store'                                                     : TokenSourceStorePage,
			'token-source-edit'                                                      : TokenSourceEditPage,
			'token-vendor'                                                           : TokenVendorPage,
			'token-whitelist-edit'                                                   : TokenWhitelistEditPage,
			'token-meta-edit'                                                        : TokenMetaEditPage,
			'term-edit'                                                              : TermEditPage,
			'user-show'                                                              : UserShowPage,
			'user-credit-balance-index'                                              : UserCreditBalanceIndexPage,
			'user-token-balance-index'                                               : UserTokenBalanceIndexPage,
			[`column-${this.namespace}-${this.namespace}_token_meta-featured-image`] : TokenMetaFeaturedImageColumn,
			'column-user-credit-balance'                                             : UserCreditBalanceColumn,
		} as any;
		return routes;
	}

	/**
	 * Gets the redirects for the links in the sidebar
	 * @returns {Array<Object>}
	 */
	protected getRedirects(): Array<Object> {
		const redirects = [
			{
				from: `${this.namespace}-inventory`,
				to: `/${this.namespace}/user/me`,
			},
			{
				from: `${this.namespace}-dashboard`,
				to: `${this.apiHost}/dashboard`,
			},
		];
		return redirects;
	}

	/**
	 * Gets the links to highlight in the sidebar
	 * @returns {any}
	 */
	protected getHighlights(): any {
		const highlights = {
			[`${this.namespace}-token-vendor`]: [
				`/wp-admin/admin.php?page=${this.namespace}-token-address-index`,
				`/wp-admin/admin.php?page=${this.namespace}-token-address-show`,
				`/wp-admin/admin.php?page=${this.namespace}-token-address-store`,
				`/wp-admin/admin.php?page=${this.namespace}-token-address-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-token-address-verify`,
				`/wp-admin/admin.php?page=${this.namespace}-token-address-balance-index`,
				`/wp-admin/admin.php?page=${this.namespace}-token-promise-index`,
				`/wp-admin/admin.php?page=${this.namespace}-token-promise-show`,
				`/wp-admin/admin.php?page=${this.namespace}-token-promise-store`,
				`/wp-admin/admin.php?page=${this.namespace}-token-promise-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-token-source-index`,
				`/wp-admin/admin.php?page=${this.namespace}-token-source-show`,
				`/wp-admin/admin.php?page=${this.namespace}-token-source-store`,
				`/wp-admin/admin.php?page=${this.namespace}-token-source-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-token-meta-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-token-vendor-show`,
				`/wp-admin/admin.php?page=${this.namespace}-token-whitelist-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-user-token-balance-index`,
				`/wp-admin/edit.php?post_type=${this.namespace}_token_meta`,
				`/wp-admin/edit-tags.php?taxonomy=${this.namespace}_token_category&post_type=${this.namespace}_token_meta`,
			],
			[ `${this.namespace}-credit-vendor` ]: [
				`/wp-admin/admin.php?page=${this.namespace}-credit-group-account-index`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-group-index`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-group-show`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-group-store`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-group-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-group-whitelist-edit`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-transaction-index`,
				`/wp-admin/admin.php?page=${this.namespace}-credit-transaction-store`,
				`/wp-admin/admin.php?page=${this.namespace}-user-credit-balance-index`,
			],
		} as any;
		return highlights;
	}
	
	/**
	 * Renders the admin view
	 * @param {HTMLElement} element Root element for rendering
	 * @param {any} ViewComponent Component to render
	 * @param {any} props Component props
	 * @returns void
	 */
	protected render( element: HTMLElement, ViewComponent: any, props: any, view: string ): void {
		const pageContainer = document.createElement( 'div' );
		element.appendChild( pageContainer );
		if ( view.includes( 'column' ) ) {
			render(
				<Provider container={ this.container }>
					<ViewComponent { ...props } />
				</Provider>,
				pageContainer
			);
		} else {
			render(
				<Provider container={ this.container }>
					<AppLayout page={ <ViewComponent { ...props } /> } />
				</Provider>,
				pageContainer
			);
		}

	}

	/**
	 * Replaces the links in the admin sidebar
	 * @returns void
	 */
	protected registerRedirects(): void {
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
	
	/**
	 * Highlights the links in the admin sidebar
	 * @param {string} view Current view
	 * @returns void
	 */
	protected highlightMenu(): void {
		const adminMenu = document.querySelector( `#adminmenu #toplevel_page_${this.namespace}` );
		if ( !adminMenu ) {
			return;
		}
		const path = window.location.pathname + window.location.search;
		const highlights = this.getHighlights();
		Object.keys( highlights ).forEach( key => {
			const selector = `a[href='admin.php?page=${key}']`;
			let menuItemElement = adminMenu.querySelector( selector );
			if ( menuItemElement ) {
				menuItemElement = menuItemElement.closest( 'li' );
				if ( highlights[ key ].includes( path ) ) {
					menuItemElement.classList.add( 'current' );
					adminMenu.classList.remove( 'wp-not-current-submenu' );
					adminMenu.classList.add( 'wp-has-current-submenu', 'wp-menu-open' );
				}
			}
		} );
	}
}
