import * as React from 'react'

import { 
	TextareaControl,
	Flex,
	Disabled,
} from '@wordpress/components'

interface SourceEditFormProps {
	loading: boolean
	onChange: any
	editData: any
}

export default function SourceEditForm( props: SourceEditFormProps ) {
	function onWhitelistFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.assets = value
		props.onChange( state )
	}

	return (
		<form>
			<Flex style={ { maxWidth: "320px" } }>
				<Disabled
					//@ts-ignore
					isDisabled={ props.loading }
				>
					<TextareaControl
						label="Whitelisted Assets"
						help="Comma-separated values. Assets which are allowed for making promises."
						value={ props.editData.assets }
						onChange={ onWhitelistFieldChange }
					/>
				</Disabled>
			</Flex>
		</form>
	)
}
