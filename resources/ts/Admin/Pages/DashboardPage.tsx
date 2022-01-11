import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';

import { 
	Card,
	CardBody,
	CardHeader,
	CardFooter,
	Button,
	Dashicon,
} from '@wordpress/components';

interface DashboardCardItem {
	title: string;
	description: string;
	icon: string;
	url: string;
	admin: boolean;
}

interface DashboardPageData {
	is_admin: boolean;
	integration_can_connect: boolean;
	user_can_connect: boolean;
}

interface DashboardPageProps {
	pageData: DashboardPageData; 
}

interface DashboardPageState {
	cards: any;
	offlineRoutesUser: Array<string>;
	offlineRoutesIntegration: Array<string>;
	adminRoutes: Array<string>;
}

export default class DashboardPage extends Component<DashboardPageProps, DashboardPageState> {
	state: DashboardPageState = {
		cards: {
			dashboard: {
				title: 'Main Dashboard',
				description: 'Tokenpass main dashboard (external).',
				icon: 'dashboard',
				url: 'https://tokenpass.tokenly.com/dashboard',
			},
			inventory: {
				title: 'Inventory',
				description: 'View the list of currently owned token assets.',
				icon: 'money',
				url: '/tokenly/user/me',
			},
			connection: {
				title: 'Connection',
				description: 'Connect or disconnect to Tokenpass network.',
				icon: 'admin-plugins',
				url: '/wp-admin/admin.php?page=tokenly-connection',
			},
			tokenVendor: {
				title: 'Token Vendor',
				description: 'Manage token assets.',
				icon: 'money-alt',
				url: '/wp-admin/admin.php?page=tokenly-token-vendor',
			},
			creditVendor: {
				title: 'Credit Vendor',
				description: 'Manage credit groups and transactions.',
				icon: 'money-alt',
				url: '/wp-admin/admin.php?page=tokenly-credit-group-index',
			},
			settings: {
				title: 'Settings',
				description: 'Manage plugin settings.',
				icon: 'admin-settings',
				url: '/wp-admin/admin.php?page=tokenly-settings',
			},
		},
		offlineRoutesUser: [
			'connection'
		],
		offlineRoutesIntegration: [
			'settings',
		],
		adminRoutes: [
			'creditVendor',
			'tokenVendor',
			'settings',
		],
	}
	constructor( props: DashboardPageProps ) {
		super( props );
		this.canView = this.canView.bind( this );
	}

	canView( key: string ) {
		let canView = false;
		if ( this.props.pageData?.integration_can_connect ?? false ) {
			if ( this.props.pageData?.user_can_connect ?? false ) {
				canView = true;
			} else if ( this.state.offlineRoutesUser.includes( key ) ) {
				canView = true;
			}
		}
		if ( this.state.offlineRoutesIntegration.includes( key ) ) {
			canView = true;
		}
		if ( this.state.adminRoutes.includes( key ) && this.props.pageData.is_admin === false ) {
			canView = false;
		}
		return canView;
	}

	render() {
		let cards = [] as any;
		Object.keys( this.state.cards ).map( ( key: string, index ) => {
			const cardItem = this.state.cards[ key ];
			if ( this.canView( key ) ) {
				cards.push(
					<Card>
						<CardHeader style={{display: 'flex', justifyContent: 'flex-start',}}><Dashicon icon={cardItem.icon as any} /><h3>{cardItem.title}</h3></CardHeader>
						<CardBody size="large">{cardItem.description}</CardBody>
						<CardFooter>
							<Button isPrimary href={cardItem.url}>Visit page</Button>
						</CardFooter>
					</Card>
				);
			}
		});
		return (
			<Page title={'Tokenpass Dashboard'}>
				<div className="dashboard-card-grid">
					{cards}
				</div>
			</Page>
		);
	}
}
