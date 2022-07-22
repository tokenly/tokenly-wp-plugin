import * as React from 'react'
import ConnectionInfo from './ConnectionInfo'
import ConnectionActions from './ConnectionActions'
import UserInterface from '../../Interfaces/Models/UserInterface'

import { 
	Flex
} from '@wordpress/components'

interface ConnectionProps {
	user: UserInterface
}

export default function Connection( props: ConnectionProps ) {
	return (
		<Flex
			//@ts-ignore
			direction="column"
			gap={4}
		>
			<ConnectionInfo status={ props?.user?.canConnect } user={ props?.user } />
			<ConnectionActions disabled={ !props?.user } status={ props?.user?.canConnect } />
		</Flex>
	)
}
 

