import * as React from 'react'
import { useInjection } from 'inversify-react'
import Page from '../Page'
import { TYPES } from '../../Types'
import GridMenu from '../../Components/GridMenu'
import { GridMenuItemInterface } from '../../Components/GridMenu'

interface VendorPageProps {
	//
}

export default function VendorPage( props: VendorPageProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const routes: any = useInjection( TYPES.Variables.routes )
	const dictionary: any = useInjection( TYPES.Variables.dictionary )
	const menuItems: Array<GridMenuItemInterface> = [
		{
			key: 'promises',
			title: dictionary.get(
				'tokenVendorPromisesMenuItemTitle'
			),
			description: dictionary.get(
				'tokenVendorPromisesMenuItemDescription'
			),
			icon: 'database',
			route: routes.admin.get( `${namespace}_token_promise_index` ),
		},
		{
			key: 'whitelist',
			title: dictionary.get(
				'tokenVendorWhitelistMenuItemTitle'
			),
			description: dictionary.get(
				'tokenVendorWhitelistMenuItemDescription'
			),
			icon: 'list-view',
			route: routes.admin.get( `${namespace}_token_whitelist_edit` ),
		},
		{
			key: 'source',
			title: dictionary.get(
				'tokenVendorSourcesMenuItemTitle'
			),
			description: dictionary.get(
				'tokenVendorSourcesMenuItemDescription'
			),
			icon: 'portfolio',
			route: routes.admin.get( `${namespace}_token_source_index` ),
		},
		{
			key: 'address',
			title: dictionary.get(
				'tokenVendorAddressesMenuItemTitle'
			),
			description: dictionary.get(
				'tokenVendorAddressesMenuItemDescription'
			),
			icon: 'portfolio',
			route: routes.admin.get( `${namespace}_token_address_index` ),
		},
		{
			key: 'meta',
			title: dictionary.get(
				'tokenVendorMetaMenuItemTitle'
			),
			description: dictionary.get(
				'tokenVendorMetaMenuItemDescription'
			),
			icon: 'media-document',
			route: routes.post.get( `token_meta_${namespace}_token_meta` ),
		},
		{
			key: 'categories',
			title: dictionary.get(
				'tokenVendorCategoriesMenuItemTitle'
			),
			description: dictionary.get(
				'tokenVendorCategoriesMenuItemDescription'
			),
			icon: 'category',
			route: routes.term.get( `token_meta_${namespace}_token_category` ),
			append: `&post_type=${namespace}_token_meta`,
		},
	]

	return (
		<Page title={ dictionary.get( 'tokenVendorTitle' ) } >
			<GridMenu items={ menuItems } />
		</Page>
	)
}
