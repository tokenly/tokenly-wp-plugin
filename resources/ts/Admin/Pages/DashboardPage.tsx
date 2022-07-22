import * as React from 'react'
import { useInjection } from 'inversify-react'
import Page from './Page'
import { TYPES } from '../../Types'
import GridMenu from '../Components/GridMenu'
import { GridMenuItemInterface } from '../Components/GridMenu'

interface DashboardPageProps {
	//
}

export default function DashboardPage( props: DashboardPageProps ) {
	const apiHost: string = useInjection( TYPES.Variables.apiHost )
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const routes: any = useInjection( TYPES.Variables.routes )
	const dictionary: any = useInjection( TYPES.Variables.dictionary )
	const menuItems: Array<GridMenuItemInterface> = [
		{
			key: 'dashboard',
			title: dictionary.get(
				'dashboardDashboardMenuItemTitle' ),
			description: dictionary.get(
				'dashboardDashboardMenuItemDescription' ),
			icon: 'dashboard',
			href: `${apiHost}/dashboard`,
		},
		{
			key: 'inventory',
			title: dictionary.get(
				'dashboardInventoryMenuItemTitle' ),
			description: dictionary.get(
				'dashboardInventoryMenuItemDescription' ),
			icon: 'money',
			href: `/${namespace}/user/me`,
		},
		{
			key: 'tokenVendor',
			title: dictionary.get(
				'dashboardTokenVendorMenuItemTitle' ),
			description: dictionary.get(
				'dashboardTokenVendorMenuItemDescription' ),
			icon: 'money-alt',
			route: routes.admin.get( `${namespace}_token_vendor` ),
		},
		{
			key: 'creditVendor',
			title: dictionary.get(
				'dashboardCreditVendorMenuItemTitle' ),
			description: dictionary.get(
				'dashboardCreditVendorMenuItemDescription' ),
			icon: 'money-alt',
			route: routes.admin.get( `${namespace}_credit_vendor` ),
		},
		{
			key: 'settings',
			title: dictionary.get(
				'dashboardSettingsMenuItemTitle' ),
			description: dictionary.get(
				'dashboardSettingsMenuItemDescription' ),
			icon: 'admin-settings',
			route: routes.admin.get( `${namespace}_settings` ),
		},
	]

	return (
		<Page title={ dictionary.get( 'dashboardTitle' ) }>
			<GridMenu items={ menuItems } />
		</Page>
	)
}
