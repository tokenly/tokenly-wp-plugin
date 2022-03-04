import * as React from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
import { TYPES } from './../../Types';
import GridMenu from '../../Components/GridMenu';

interface VendorPageProps {
	//
}

export default function VendorPage( props: VendorPageProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const routes: any = useInjection( TYPES.Variables.routes );
	const menuItems = {
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

	return (
		<Page title="Token Vendor">
			<GridMenu items={ menuItems } />
		</Page>
	);
}
