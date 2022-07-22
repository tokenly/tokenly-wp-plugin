import * as React from 'react'

import {
	Flex,
	TextareaControl,
} from '@wordpress/components'

interface AddressVerifyFormProps {
	onChange: ( data: any ) => void
	verifyData: any
}

export default function AddressVerifyForm( props: AddressVerifyFormProps ) {
	function onSignatureFieldChange( value: any ) {
		const state = Object.assign( {}, props.verifyData )
		state.signature = value
		props.onChange( state )
	}

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { maxWidth: "320px" } }
		> 
			<TextareaControl
				label="Cryptographic Signature"
				value={ props.verifyData?.signature }
				onChange={ onSignatureFieldChange }
			/>
		</Flex>
	)
}
