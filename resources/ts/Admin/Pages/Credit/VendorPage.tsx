import * as React from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
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

interface VendorPageProps {
	is_admin: boolean;
	integration_can_connect: boolean;
	user_can_connect: boolean;
}

export default function VendorPage( props: VendorPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const routes: any = useInjection( TYPES.Variables.routes );
	const cardData = {
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
		<Page title="Token Vendor">
			<div className="dashboard-card-grid">
				{ cards }
			</div>
		</Page>
	);
}
