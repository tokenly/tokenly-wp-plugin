import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import CardActions from '../CardActions'

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
} from '@wordpress/components'

interface BalanceCardProps {
	balance: any
	username?: string
}

export default function BalanceCard( props: BalanceCardProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl )
	const namespace = useInjection( TYPES.Variables.namespace )

	function getNameFormatted(): string {
		let assetName: string = ''
		if ( props.balance?.meta?.name ) {
			assetName = props.balance.meta.name
		} else {
			assetName = getName()
		}
		return assetName
	}

	function getName(): string {
		let name: string = ''
		if ( props.balance?.asset?.address ) {
			name = props.balance.asset.address
		}
		if ( props.balance?.asset?.index ) {
			name = `${name}:${props.balance.asset.index}`
		}
		return name
	}

	function getPromiseLink(): string {
		let link = `${ adminPageUrl }${ namespace }-token-promise-store&asset=${ getName() }`
		if ( props.username ) {
			link = `${link}&destination=${props.username}`
		}
		return link
	}

	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<b title={ getName() }>{ getNameFormatted() }</b>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				{ props?.balance?.quantity?.value ?? 0 }
			</CardBody>
			<CardFooter>
				<CardActions
					actions={
						[
							{
								title: 'Make Promise',
								href: getPromiseLink(),
							},
							{
								title: 'Add to Whitelist',
								disabled: true,
							},
						]
					}
				/>
			</CardFooter>
		</Card>
	)
}
 

