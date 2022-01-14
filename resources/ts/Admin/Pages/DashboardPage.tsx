import * as React from 'react';
import { useInjection } from 'inversify-react';
import Page from './Page';
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

export default function DashboardPage( props: DashboardPageProps ) {
	const apiHost: string = useInjection( TYPES.Variables.apiHost );
	const brand: string = useInjection( TYPES.Variables.brand );
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );

	const offlineRoutesUser = [
		'connection'
	];
	const offlineRoutesIntegration = [
		'settings',
	];
	const adminRoutes = [
		'creditVendor',
		'tokenVendor',
		'settings',
	];

	const cardData = {
		dashboard: {
			title: 'Main Dashboard',
			description: `${brand} main dashboard (external).`,
			icon: 'dashboard',
			url: `${apiHost}/dashboard`,
		},
		inventory: {
			title: 'Inventory',
			description: 'View the list of currently owned token assets.',
			icon: 'money',
			url: `/${namespace}/user/me`,
		},
		connection: {
			title: 'Connection',
			description: `Connect or disconnect to ${brand} network.`,
			icon: 'admin-plugins',
			url: `${adminPageUrl}${namespace}-connection`,
		},
		tokenVendor: {
			title: 'Token Vendor',
			description: 'Manage token assets.',
			icon: 'money-alt',
			url: `${adminPageUrl}${namespace}-token-vendor`,
		},
		creditVendor: {
			title: 'Credit Vendor',
			description: 'Manage credit groups and transactions.',
			icon: 'money-alt',
			url: `${adminPageUrl}${namespace}-credit-vendor`,
		},
		settings: {
			title: 'Settings',
			description: 'Manage plugin settings.',
			icon: 'admin-settings',
			url: `${adminPageUrl}${namespace}-settings`,
		},
	} as any;

	function canView( key: string ) {
		let canView = false;
		if ( props.pageData?.integration_can_connect ?? false ) {
			if ( props.pageData?.user_can_connect ?? false ) {
				canView = true;
			} else if ( offlineRoutesUser.includes( key ) ) {
				canView = true;
			}
		}
		if ( offlineRoutesIntegration.includes( key ) ) {
			canView = true;
		}
		if ( adminRoutes.includes( key ) && props.pageData.is_admin === false ) {
			canView = false;
		}
		return canView;
	}

	let cards = [] as any;
	Object.keys( cardData ).map( ( key: string, index ) => {
		const cardItem = cardData[ key ];
		if ( canView( key ) ) {
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
		<Page title={ `${brand} Dashboard` }>
			<div className="dashboard-card-grid">
				{ cards }
			</div>
		</Page>
	);
}
