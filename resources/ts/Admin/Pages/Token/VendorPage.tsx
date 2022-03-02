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
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const routes: any = useInjection( TYPES.Variables.routes );
	const cardData = {
		promises: {
			title: 'Promises',
			description: `View and manage token promises.`,
			icon: 'database',
			route: routes.admin[`${namespace}_token_promise_index`],
		},
		whitelist: {
			title: 'Whitelist',
			description: 'View and manage the list of assets allowed for viewing and transactions.',
			icon: 'list-view',
			route: routes.admin[`${namespace}_token_whitelist_edit`],
		},
		source: {
			title: 'Sources',
			description: `View and manage sources for promise transactions.`,
			icon: 'portfolio',
			route: routes.admin[`${namespace}_token_source_index`],
		},
		address: {
			title: 'Addresses',
			description: 'View and manage addresses for promise transactions.',
			icon: 'portfolio',
			route: routes.admin[`${namespace}_token_address_index`],
		},
		meta: {
			title: 'Meta',
			description: 'View and manage additional information about the token assets.',
			icon: 'media-document',
			route: routes.post[`token_meta_${namespace}_token_meta`],
		},
		categories: {
			title: 'Categories',
			description: 'View and manage token categories.',
			icon: 'category',
			route: routes.term[`token_meta_${namespace}_token_category`],
			append: `&post_type=${namespace}_token_meta`,
		},
	} as any;

	function canView( key: string ): boolean {
		return ( cardData[ key ]?.route?.access ?? false );
	}

	function get_url( cardItem: any ): string {
		let url: string = cardItem?.route?.url;
		if ( cardItem?.append ) {
			url = url + cardItem.append;
		}
		return url;
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
						<Button isPrimary href={ get_url( cardItem ) }>Visit Page</Button>
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
