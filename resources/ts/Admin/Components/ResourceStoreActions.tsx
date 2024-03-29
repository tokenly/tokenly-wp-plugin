import * as React from 'react'

import { 
	Flex,
	Button,
} from '@wordpress/components'

interface ResourceEditActionsProps {
	storing: boolean
	loading?: boolean
	onStore?: any
	onCancel: any
	name: string
	children?: any
}

export default function ResourceEditActions( props: ResourceEditActionsProps ) {
	return (
		<Flex justify="flex-start" align="center" >
			<Button
				isPrimary
				isBusy={ props.storing }
				onClick={ props.onStore }
				type="submit"
			>
				{ `Submit` }
			</Button>
			<Button
				isTertiary
				onClick={ props.onCancel }
			>
				Cancel
			</Button>
			{ props.children }
		</Flex>
	)
}
 

