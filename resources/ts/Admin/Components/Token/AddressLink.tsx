import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import {
	Button,
} from '@wordpress/components'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'

interface AddressLinkProps {
	id: string,
	label?: string,
	text?: boolean,
}

export default function AddressLink( props: AddressLinkProps ) {
	const routes: RouteManagerInterface = useInjection( TYPES.Variables.routes )
	const id = props.id
	const title = props?.label ?? id
	if ( props.text ) {
		return (
			<b><span>{ title }</span></b>
		)
	}
	return (
		<Button
			isLink	
			href={ 
				routes.get(
					'admin',
					'token_address_show',
					{
						address: id
					}
				)
			 }
			style={ { flexShrink: 0 } }
		>
				{ title }
		</Button>
	)
}
 

