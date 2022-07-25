import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import { 
	Card,
	CardHeader,
    CardBody,
    CardFooter,
    Flex,
    Button,
    Dashicon,
} from '@wordpress/components'

interface GridMenuProps {
	items: Array<GridMenuItemInterface>
}

export interface GridMenuItemInterface {
	key: string
	title: string
	description: string
	icon: string
    route?: any
	href?: string
	append?: string
}

export default function GridMenu( props: GridMenuProps ) {
	const userRoles: string = useInjection( TYPES.Variables.userRoles )

	function canView( key: string ): boolean {
		return (
			props.items[ key as any ].href ||
			( props.items[ key as any ]?.route?.access ?? false )
		)
	}

	function getUrl( menuItem: any ): string {
		let url: string = ""
		if ( menuItem?.route?.url ) {
			url = menuItem?.route?.url
		} else if (menuItem?.href) {
			url = menuItem.href
		}
		if ( menuItem?.append ) {
			url = url + menuItem.append
		}
		return url
	}

	let cards = [] as any
	cards = Object.keys( props.items ).map( ( key: string ) => {
		const canViewResult = canView( key );
		if ( !canViewResult && !userRoles.includes( 'administrator' ) ) {
			return null;
		}
		const item = props.items[ key as any ]
		const url = getUrl( item )
			return (
				<Card style={ { opacity: canViewResult ? 1 : 0.5 } }>
					<CardHeader>
						<Flex justify="flex-start">
							<Dashicon icon={ item.icon as any } />
							<h3>{ item.title }</h3>
						</Flex>
					</CardHeader>
					<CardBody size="large">{ item.description }</CardBody>
					<CardFooter>
						<Button 
							isPrimary
							href={ url }
							disabled={ !canViewResult }
						>
							Visit Page
						</Button>
					</CardFooter>
				</Card>
			)
	} )

    return <div className="dashboard-card-grid">{ cards }</div>
}
