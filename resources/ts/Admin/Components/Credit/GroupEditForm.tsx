import * as React from 'react'

import { 
	TextControl,
	Flex,
} from '@wordpress/components'

interface GroupEditFormProps {
	loadingGroup: boolean
	editData: any
	onChange: any
}

export default function GroupEditForm( props: GroupEditFormProps ) {

	function onNameFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.name = value
		props.onChange( state )
	}

	return (
		<div style={ { maxWidth: "320px" } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<TextControl
					label="Name"
					value={ props.editData.name }
					onChange={ onNameFieldChange }
					required
				/>
			</Flex>
		</div>
	)
}
