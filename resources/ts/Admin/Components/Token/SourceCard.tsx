import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import CardActions from '../CardActions'

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	Flex,
	CardFooter
} from '@wordpress/components'
import SourceInterface from '../../../Interfaces/Models/Token/SourceInterface'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'
import DictionaryInterface from '../../../Interfaces/DictionaryInterface'

interface SourceCardProps {
	source: SourceInterface
}

export default function SourceCard( props: SourceCardProps ) {
	const dictionary: DictionaryInterface = useInjection(
		TYPES.Variables.dictionary
	)
	const routes: RouteManagerInterface = useInjection(
		TYPES.Variables.routes
	)
	
	function getAssets(): string {
		let listing = 'all'
		const assets = props.source?.assets
		if ( assets.length > 0 ) {
			listing = assets.join( ', ' )
		}
		return listing
	}

	const addressId = props?.source?.addressId
	const sourceHref = routes.get(
		'admin', 'token_source_show', { source: addressId }
	)
	const sourceText = 
		props.source.address?.label
			? props.source.address.label
			: `${addressId}`
	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<div title={ addressId }>
					<b>
						<Button isLink href={ sourceHref }>
							{ sourceText }
						</Button>
						{ !props.source?.address &&
							<span> [!]</span>
						}
					</b>
				</div>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<Flex style={ { width: '100%', alignItems: 'center' } }>
					<div style={ { flex: 1 } }>
						<div>
							<span style={{marginRight: 4}}>
								{ dictionary.get(
									'tokenSourceCardWhitelistLabel'
								) }
							</span>
							<b>{ getAssets() }</b>
						</div>
					</div>
				</Flex>
			</CardBody>
			<CardFooter>
				<CardActions actions={
					[
						{
							title: 'View Details',
							href: sourceHref
						},
						{
							title: 'Edit Source',
							href: routes.get(
								'admin',
								'token_source_edit',
								{
									source: addressId
								}
							)
						}
					]
				}
				/>
			</CardFooter>
		</Card>
	)
}

