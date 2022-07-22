import * as React from 'react'
import UserLink from '../UserLink'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import { 
	 Flex,
	 Dashicon,
} from '@wordpress/components'
import RouteManagerInterface
	from '../../../Interfaces/Models/RouteManagerInterface'
import PromiseInterface from '../../../Interfaces/Models/Token/PromiseInterface'

interface PromiseParticipantsProps {
	promise: PromiseInterface
}

export default function PromiseParticipants(
	props: PromiseParticipantsProps
) {
	const routes: RouteManagerInterface = useInjection( TYPES.Variables.routes )

	function getUserLink(id: number): string {
		return routes.get(
			'admin',
			'user_token_balance_index',
			{
				id: id
			}
		)
	}

	return (
		<Flex>
			<span>Participants: </span>
			{ props.promise &&
				<Flex gap={ 0 } align="center" justify="flex-start">
					<UserLink
						url={ getUserLink(
							props.promise?.promiseMeta?.sourceUser?.id
						) }
						alt={ props?.promise?.sourceId }
						name={ props?.promise?.promiseMeta?.sourceUser?.name }
					/>
					<Dashicon
						style={ { margin: '0 5px' } }
						icon="arrow-right-alt"
					/>
					<UserLink
						url={ getUserLink(
							props.promise?.promiseMeta?.destinationUser?.id
						) }
						alt={ props?.promise?.destination }
						name={
							props?.promise?.promiseMeta?.destinationUser?.name
						}
					/>
				</Flex>
			}
		</Flex>
	)
}
 

