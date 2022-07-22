import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import CardActions from '../CardActions'

interface GroupCardActionsProps {
	group: string
}

export default function GroupCardActions( props: GroupCardActionsProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl )
	const namespace = useInjection( TYPES.Variables.namespace )

	return (
		<CardActions
			actions={ [
					{
						title: 'Make Transaction',
						href: `${adminPageUrl}${namespace}-credit-transaction-store&group=${props.group}`,
					},
					{
						title: 'View Details',
						href: `${adminPageUrl}${namespace}-credit-group-show&id=${props.group}`,
					},
					{
						title: 'Edit Group',
						href: `${adminPageUrl}${namespace}-credit-group-edit&id=${props.group}`,
					},
			] }
		/>
	)
}
 

