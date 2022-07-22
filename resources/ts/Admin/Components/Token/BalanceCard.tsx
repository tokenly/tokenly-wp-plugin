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
import RouteManagerInterface from '../../../Interfaces/Models/RouteManagerInterface'
import BalanceInterface from '../../../Interfaces/Models/Token/BalanceInterface'

interface BalanceCardProps {
	balance: BalanceInterface
	username?: string
}

export default function BalanceCard( props: BalanceCardProps ) {
	const routes: RouteManagerInterface = useInjection(
		TYPES.Variables.routes
	)

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
								href: routes.get(
									'admin',
									'token_promise_store',
									{
										asset: getName(),
										... ( props.username ) && {
											destination: props.username
										}
									}
								)
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
 

