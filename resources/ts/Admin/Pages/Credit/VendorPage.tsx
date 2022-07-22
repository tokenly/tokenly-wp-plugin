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
			key: 'groups',
			title: dictionary.get(
				'creditVendorGroupsMenuItemTitle'
			),
			description: dictionary.get(
				'creditVendorGroupsMenuItemDescription'
			),
			icon: 'database',
			route: routes.admin.get(
				`${namespace}_credit_group_index`
			),
		},
		{
			key: 'whitelist',
			title: dictionary.get(
				'creditVendorWhitelistMenuItemTitle'
				),
			description: dictionary.get(
				'creditVendorWhitelistMenuItemDescription'
				),
			icon: 'list-view',
			route: routes.admin.get(
				`${namespace}_credit_group_whitelist_edit`
			),
		},
	]

	return (
		<Page title={ dictionary.get( 'creditVendorTitle' ) }>
			<GridMenu items={ menuItems } />
		</Page>
	)
}
