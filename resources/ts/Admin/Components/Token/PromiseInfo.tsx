import * as React from 'react'
import PromiseParticipants from './PromiseParticipants'
import * as dayjs from 'dayjs'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import {
	Button,
	Flex,
} from '@wordpress/components'

interface AddressInfoProps {
	promise: any
	verbose?: boolean
}

export default function AddressInfo( props: AddressInfoProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl )
	const namespace = useInjection( TYPES.Variables.namespace )

	function getListItems() {
		const properties = getProperties()
		return properties.map( ( property ) => {
			return (
				<div>
					<span>{ property.label }: </span>
					<b>
					{ property.value
					?	<span>{ property.value }</span>
					:	<span style={ { opacity: 0.6 } }>
							Not Specified
						</span>
					}
					</b>
				</div>
			)
		} )
	}

	function getAssetName(): string {
		let name: string
		if ( props.promise.token_meta ) {
			name = props.promise.token_meta.name
		} else {
			name = props.promise.asset.address
			if ( props.promise.asset.index ) {
				name = `${name}:${props.promise.asset.index}`
			}
		}
		return name
	}

	function getProperties() {
		const properties = [
			{
				label: 'Asset',
				value: getAssetName(),
			},
			{
				label: 'Quantity',
				value: props.promise?.quantity?.value ?? props.promise?.quantity?.value_sat,
			},
		]
		if ( props.verbose ) {
			properties.push(
				{
					label: 'ID',
					value: props.promise?.promise_id,
				},
				{
					label: 'Ref',
					value: props.promise?.ref,
				},
				{
					label: 'Note',
					value: props.promise?.note,
				},
				{
					label: 'Created at',
					value: dateFormatted( props.promise?.created_at ),
				},
				{
					label: 'Updated at',
					value: dateFormatted( props.promise?.updated_at ),
				},
			)
		}
		return properties
	}

	function isPromiseValid() {
		return ( props.promise && typeof props.promise === 'object' )
	}

	function dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return
	}

	return (
		<Flex>
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<div>
						<span>Source: </span>
						<Button
							isLink
							href={ `${adminPageUrl}${namespace}-token-source-show&source=${props.promise?.source_id}` }
						>
							<span>{props.promise?.source?.address.label ?? props.promise.source_id}</span>
						</Button>
					</div>
					<PromiseParticipants promise={ props.promise } />
					{ getListItems() }
				</div>
			</Flex>
		</Flex>
	)
}
