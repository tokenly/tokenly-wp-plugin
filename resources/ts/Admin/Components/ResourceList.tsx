import * as React from 'react'

import { 
	Flex,
} from '@wordpress/components'
import CollectionInterface from '../../Interfaces/Collections/CollectionInterface'

interface ResourceListProps {
	items: CollectionInterface
	component: any
	itemProp: string
	props?: any
	notFoundLabel?: string
}

export default function ResourceList( props: ResourceListProps ) {
	let listItems:JSX.Element[] = []
	if ( props.items ) {
		const values = Array.from( props?.items.values() )
		listItems = values.map( ( item: any ) => {
			const cardProps = {
				[ props.itemProp ]: item,
			}
			return <props.component {...cardProps} { ...props.props ?? {} } />
		} )
	}
	return (
		<div style={ { width: '100%' } }>
			{ ( props.items.size )
			?	<Flex
					style={ { width: '100%' } }
					// @ts-ignore
					direction="column"
				>
					{ listItems }
				</Flex>
			: 	<div style={ { opacity: 0.5 } }>{ `No ${props.notFoundLabel ?? 'items'} were found.` }</div>
			}
		</div>
	)
}
