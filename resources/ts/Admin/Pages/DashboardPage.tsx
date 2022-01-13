import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { TYPES } from './../../Types';

import { 
	Card,
	CardBody,
	CardHeader,
	CardFooter,
	Button,
	Dashicon,
	Flex,
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
	cards?: any;
	offlineRoutesUser: Array<string>;
	offlineRoutesIntegration: Array<string>;
	adminRoutes: Array<string>;
}

export default class DashboardPage extends Component<DashboardPageProps, DashboardPageState> {
	@resolve( TYPES.Variables.apiHost )
	apiHost: string;
	@resolve( TYPES.Variables.brand )
	brand: string;
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	state: DashboardPageState = {
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

	componentWillMount() {
		this.setState( {
			cards: {
				dashboard: {
					title: 'Main Dashboard',
					description: `${this.brand} main dashboard (external).`,
					icon: 'dashboard',
					url: `${this.apiHost}/dashboard`,
				},
				inventory: {
					title: 'Inventory',
					description: 'View the list of currently owned token assets.',
					icon: 'money',
					url: `/${this.namespace}/user/me`,
				},
				connection: {
					title: 'Connection',
					description: `Connect or disconnect to ${this.brand} network.`,
					icon: 'admin-plugins',
					url: `${this.adminPageUrl}${this.namespace}-connection`,
				},
				tokenVendor: {
					title: 'Token Vendor',
					description: 'Manage token assets.',
					icon: 'money-alt',
					url: `${this.adminPageUrl}${this.namespace}-token-vendor`,
				},
				creditVendor: {
					title: 'Credit Vendor',
					description: 'Manage credit groups and transactions.',
					icon: 'money-alt',
					url: `${this.adminPageUrl}${this.namespace}-credit-vendor`,
				},
				settings: {
					title: 'Settings',
					description: 'Manage plugin settings.',
					icon: 'admin-settings',
					url: `${this.adminPageUrl}${this.namespace}-settings`,
				},
			}
		} );
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
						<CardHeader>
							<Flex justify="flex-start">
								<Dashicon icon={ cardItem.icon as any } />
								<h3>{ cardItem.title }</h3>
							</Flex>
						</CardHeader>
						<CardBody size="large">{ cardItem.description }</CardBody>
						<CardFooter>
							<Button isPrimary href={ cardItem.url }>Visit page</Button>
						</CardFooter>
					</Card>
				);
			}
		} );
		return (
			<Page title={ `${this.brand} Dashboard` }>
				<div className="dashboard-card-grid">
					{ cards }
				</div>
			</Page>
		);
	}
}
