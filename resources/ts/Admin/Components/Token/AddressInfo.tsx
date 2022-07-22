import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import AddressInterface from '../../../Interfaces/Models/Token/AddressInterface'

import {
	Button,
	Flex,
} from '@wordpress/components'
import RouteManagerInterface from '../../../Interfaces/Models/RouteManagerInterface'

interface AddressInfoProps {
	address?: AddressInterface
	verbose?: boolean
}

export default function AddressInfo( props: AddressInfoProps ) {
	const routes: RouteManagerInterface =
		useInjection( TYPES.Variables.routes )
	const address = props.address?.address
	return (
		<Flex
			//@ts-ignore
			direction="column"
		>
			<Flex
				//@ts-ignore
				direction="column"
				gap={0}
				style={ { opacity: props.address ? 1 : 0.5 } }
			>
				<div>
					<b>Type: </b>
					<span>{ props.address?.type ?? '-' }</span>
				</div>
				<div>
					<b>Address: </b>
					<span>{ address ?? '-' }</span>
				</div>
				{ props.verbose &&
				<div>
					<b>Assets: </b>
					{ props.address
						?	<Button
								href={
									routes.get(
										'admin',
										'token_address_balance_index',
										{
											id: address
										}
									)
								}
								isLink
							>
								View Balance
							</Button>
						:	<span>-</span>
					}
				</div>
				}
			</Flex>
		</Flex>
	)
}
