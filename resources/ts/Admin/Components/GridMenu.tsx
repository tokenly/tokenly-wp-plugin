import * as React from 'react'

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
		const item = props.items[ key as any ]
		const url = getUrl( item )
			return (
				<Card style={ { opacity: canView( key ) ? 1 : 0.5 } }>
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
							disabled={ !canView( key ) }
						>
							Visit Page
						</Button>
					</CardFooter>
				</Card>
			)
	} )

    return <div className="dashboard-card-grid">{ cards }</div>
}
