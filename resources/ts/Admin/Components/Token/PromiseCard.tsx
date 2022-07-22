import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import PromiseLink from './PromiseLink'
import PromiseInfo from './PromiseInfo'
import CardActions from '../CardActions'

import { 
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	Flex,
} from '@wordpress/components'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'
import PromiseInterface from '../../../Interfaces/Models/Token/PromiseInterface'

interface PromiseCardProps {
	promise: PromiseInterface
}

export default function PromiseCard( props: PromiseCardProps ) {
	const routes: RouteManagerInterface = useInjection(
		TYPES.Variables.routes
	)
	const promiseId = props.promise?.promiseId
	return (
		<Card size="extraSmall">
			<CardHeader>
				<Flex
					align="center"
					justify="flex-start"
				>
					<PromiseLink id={ props.promise.promiseId } />
					{ props?.promise?.pseudo == true &&
						<span>
							<span className="tokenly-component-chip">pseudo</span>
						</span>
					}
				</Flex>
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<PromiseInfo promise={ props.promise } />
			</CardBody>
			<CardFooter>
				<CardActions actions={
					[
						{
							title: 'View Details',
							href: routes.get(
								'admin',
								'token_promise_show',
								{
									promise: promiseId
								}
							)
						},
						{
							title: 'Edit Promise',
							href: routes.get(
								'admin',
								'token_promise_edit',
								{
									promise: promiseId
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
 



