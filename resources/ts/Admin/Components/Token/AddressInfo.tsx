import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import AddressInterface from '../../../Interfaces/Models/Token/AddressInterface'

import {
	Button,
	Flex,
} from '@wordpress/components'

interface AddressInfoProps {
	address?: AddressInterface
	verbose?: boolean
}

export default function AddressInfo( props: AddressInfoProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl )
	const namespace = useInjection( TYPES.Variables.namespace )
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
					<span>{ props.address?.address ?? '-' }</span>
				</div>
				{ props.verbose &&
				<div>
					<b>Assets: </b>
					{ props.address
						?	<Button
								href={ `${ adminPageUrl }${ namespace }-token-address-balance-index&id=${ props.address.address }` }
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
