import * as React from 'react'

import { 
	Button,
	Flex,
} from '@wordpress/components'

interface SavePanelProps {
	label?: string
	saving: boolean
	onClick: any
}

export default function SavePanel( props: SavePanelProps ) {
	return (
		<Flex
			//@ts-ignore
			direction="row"
			justify="flex-start"
			style={ { marginTop: '8px' } }
		>
			<Button
				isPrimary
				isLarge
				isBusy={ props.saving }
				onClick={ () => {
					props.onClick()
				} }
			>
				{ props.label ?? 'Save Settings' }
			</Button>
		</Flex>
	)
}
 

