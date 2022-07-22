import * as React from 'react'

import { 
	Flex,
	Button,
} from '@wordpress/components'

interface CardActionsProps {
	actions: Array<CardAction>
}

interface CardAction {
	title?: string,
	href?: string,
	disabled?: boolean
}

export default function CardActions( props: CardActionsProps ) {
	const listItems = props.actions.map( ( action: any ) => {
		return (
			<Button
				isSecondary
				isSmall
				{ ...action }
			>
				{ action.title }
			</Button>
		)
	} )
	return (
		<Flex justify="flex-start">{ listItems }</Flex>
	)
}
