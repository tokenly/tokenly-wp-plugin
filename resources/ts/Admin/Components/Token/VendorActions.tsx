import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import { 
	Flex,
	Button,
} from '@wordpress/components'

export default function VendorActions() {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl )
	const namespace = useInjection( TYPES.Variables.namespace )

	return (
		<Flex justify="flex-start">
			<Button
				isPrimary
				isLarge
				href={ `${adminPageUrl}${namespace}-token-promise-store` }
			>
				Register Promise
			</Button>
		</Flex>
	)
}
