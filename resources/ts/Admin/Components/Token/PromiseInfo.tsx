import * as React from 'react'
import PromiseParticipants from './PromiseParticipants'
import * as dayjs from 'dayjs'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import {
	Button,
	Flex,
} from '@wordpress/components'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'

interface AddressInfoProps {
	promise: any
	verbose?: boolean
}

export default function AddressInfo( props: AddressInfoProps ) {
	const routes: RouteManagerInterface = useInjection(
		TYPES.Variables.routes
	)
	const sourceId = props.promise?.sourceId

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
			name = props.promise.tokenMeta.name
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
				value: props.promise?.quantity?.value ?? 
					props.promise?.quantity?.valueSat,
			},
		]
		if ( props.verbose ) {
			properties.push(
				{
					label: 'ID',
					value: props.promise?.promiseId,
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
					value: dateFormatted( props.promise?.createdAt ),
				},
				{
					label: 'Updated at',
					value: dateFormatted( props.promise?.updatedAt ),
				},
			)
		}
		return properties
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
							href = {
								routes.get(
									'admin',
									'token_source_show',
									{
										source: sourceId
									}
								)
							}
						>
							<span>{props.promise?.source?.address.label ??
								sourceId}</span>
						</Button>
					</div>
					<PromiseParticipants promise={ props.promise } />
					{ getListItems() }
				</div>
			</Flex>
		</Flex>
	)
}
