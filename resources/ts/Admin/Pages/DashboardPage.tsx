import * as React from 'react';
import { useInjection } from 'inversify-react';
import Page from './Page';
import { TYPES } from './../../Types';
import GridMenu from '../Components/GridMenu';

interface DashboardPageProps {
	//
}

export default function DashboardPage( props: DashboardPageProps ) {
	const apiHost: string = useInjection( TYPES.Variables.apiHost );
	const brand: string = useInjection( TYPES.Variables.brand );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const routes: any = useInjection( TYPES.Variables.routes );
	const menuItems = {
		dashboard: {
			title: 'Main Dashboard',
			description: `${brand} main dashboard (external).`,
			icon: 'dashboard',
			href: `${apiHost}/dashboard`,
		},
		inventory: {
			title: 'Profile',
			description: 'Manage Connection and User Settings.',
			icon: 'money',
			href: `/${namespace}/user/me`,
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

	return (
		<Page title={ `${brand} Dashboard` }>
			<GridMenu items={ menuItems } />
		</Page>
	);
}
