import * as React from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
import { TYPES } from '../../Types';
import GridMenu from '../../Components/GridMenu';

interface VendorPageProps {
	//
}

export default function VendorPage( props: VendorPageProps ) {;
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const routes: any = useInjection( TYPES.Variables.routes );
	const menuItems = {
		promises: {
			title: 'Groups and Transactions',
			description: `View and manage credit groups and their transactions.`,
			icon: 'database',
			route: routes.admin[`${namespace}_credit_group_index`],
		},
		whitelist: {
			title: 'Whitelist',
			description: 'View and manage the list of groups allowed for viewing and transactions.',
			icon: 'list-view',
			route: routes.admin[`${namespace}_credit_group_whitelist_edit`],
		},
	} as any;

	return (
		<Page title="Token Vendor">
			<GridMenu items={ menuItems } />
		</Page>
	);
}
