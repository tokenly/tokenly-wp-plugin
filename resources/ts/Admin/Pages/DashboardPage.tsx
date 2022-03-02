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

interface DashboardPageProps {
	is_admin: boolean;
	integration_can_connect: boolean;
	user_can_connect: boolean;
}

export default function DashboardPage( props: DashboardPageProps ) {
	const apiHost: string = useInjection( TYPES.Variables.apiHost );
	const brand: string = useInjection( TYPES.Variables.brand );
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const routes: any = useInjection( TYPES.Variables.routes );
	const cardData = {
		dashboard: {
			title: 'Main Dashboard',
			description: `${brand} main dashboard (external).`,
			icon: 'dashboard',
			route: routes.admin[`${namespace}_dashboard`],
		},
		inventory: {
			title: 'Profile',
			description: 'Manage Connection and User Settings.',
			icon: 'money',
			route: routes.admin[`${namespace}_inventory`],
		},
		tokenVendor: {
			title: 'Token Vendor',
			description: 'Manage token assets.',
			icon: 'money-alt',
			route: routes.admin[`${namespace}_token_vendor`],
		},
		creditVendor: {
			title: 'Credit Vendor',
			description: 'Manage credit groups and transactions.',
			icon: 'money-alt',
			route: routes.admin[`${namespace}_credit_vendor`],
		},
		settings: {
			title: 'Settings',
			description: 'Manage plugin settings.',
			icon: 'admin-settings',
			route: routes.admin[`${namespace}_settings`],
		},
	} as any;

	function canView( key: string ): boolean {
		return ( cardData[ key ]?.route?.access ?? false );
	}

	let cards = [] as any;
	cards = Object.keys( cardData ).map( ( key: string, index ) => {
		const cardItem = cardData[ key ];
		if ( canView( key ) ) {
			return (
				<Card>
					<CardHeader>
						<Flex justify="flex-start">
							<Dashicon icon={ cardItem.icon as any } />
							<h3>{ cardItem.title }</h3>
						</Flex>
					</CardHeader>
					<CardBody size="large">{ cardItem.description }</CardBody>
					<CardFooter>
						<Button isPrimary href={ cardItem?.route?.url }>Visit Page</Button>
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
