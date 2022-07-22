import * as React from 'react'
import { SourceItem } from '../../../Interfaces'
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

interface SourceCardProps {
	source: SourceItem
}

export default function SourceCard( props: SourceCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl )
	const namespace = useInjection( TYPES.Variables.namespace )
	
	function getAssets(): string {
		let listing = 'all'
		const assets = props.source?.assets?.filter(Boolean)
		if ( assets.length > 0 ) {
			listing = assets.join( ', ' )
		}
		return listing
	}

	function isDisabled(): boolean {
		return ( !props.source?.address )
	}

	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<div title={ props.source.address_id }>
					<b>
						<Button
							isLink 
							href={ `${adminPageUrl}${namespace}-token-source-show&source=${ props.source.address_id }` }
						>
							{ props.source.address?.label ? props.source.address.label : `${props.source.address_id}` }
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
						<div><span>Whitelisted Assets: </span><b>{ getAssets() }</b></div>
					</div>
				</Flex>
			</CardBody>
			<CardFooter>
				<CardActions actions={
					[
						{
							title: 'View Details',
							href: `${ adminPageUrl }${ namespace }-token-source-show&source=${ props.source.address_id }`,
						},
						{
							title: 'Edit Source',
							href: `${ adminPageUrl }${ namespace }-token-source-edit&source=${ props.source.address_id }`,
						}
					]
				}
				/>
			</CardFooter>
		</Card>
	)
}
 

