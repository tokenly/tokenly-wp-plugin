import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import {
	Button,
	Flex,
} from '@wordpress/components'
import SourceInterface from '../../../Interfaces/Models/Token/SourceInterface'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'

interface SourceInfoProps {
	source: SourceInterface
}

export default function SourceInfo( props: SourceInfoProps ) {
	const routes: RouteManagerInterface = useInjection( TYPES.Variables.routes )
	const addressId = props.source?.addressId
	const addressText = props.source?.address?.label ?? props.source?.addressId
	return (
		<Flex style={ { width: '100%', alignItems: 'center' } }>
			<div style={ { flex: 1 } }>
				<div>
					<span>Type: </span>
					<b>{ props.source?.type }</b>
				</div>
				<div>
					<span>Address: </span>
					<b>
						<Button 
							isLink
							disabled={ ( !props.source.address ) }
							href = { routes.get(
								'admin',
								'token_address_show',
								{ address: addressId }
							) }
						>
							{ addressText }
						</Button>
					</b>
				</div>
				<div>
					<span>Assets (whitelisted): </span>
					<b>{ props.source?.assets.length > 0
						? props.source?.assets
						: 'all'
					}</b>
				</div>
			</div>
		</Flex>
	)
}
