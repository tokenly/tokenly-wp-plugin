import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import AddressLink from './AddressLink'
import AddressInfo from './AddressInfo'
import AddressStatus from './AddressStatus'
import CardActions from '../CardActions'

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
} from '@wordpress/components'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'
import AddressInterface
	from '../../../Interfaces/Models/Token/AddressInterface'

interface AddressCardProps {
	address: AddressInterface
}

export default function AddressCard( props: AddressCardProps ) {
	const routes: RouteManagerInterface = useInjection(
		TYPES.Variables.routes
	)
	const address = props?.address?.address
	function getCardActions(): Array<object> {
		const cardActions: Array<object> = [
			{
				title: 'View Details',
				href: routes.get(
					'admin',
					'token_address_show',
					{
						address: address
					}
				)
			},
			{
				title: 'Edit Address',
				href: routes.get(
					'admin',
					'token_address_edit',
					{
						address: address
					}
				)
			}
		]
		return cardActions
	}

	return (
		<Card size="extraSmall">
			<CardHeader>
				<Flex
					align="flex-end"
					justify="flex-start"
				>
				<AddressLink
					id={ props.address.address }
					label={ props.address.label }
				/>
				<AddressStatus address={ props.address } />
				</Flex>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<AddressInfo address={ props.address } />
			</CardBody>
			<CardFooter>
				<CardActions actions={ getCardActions() } />
			</CardFooter>
		</Card>
	)
}
 



