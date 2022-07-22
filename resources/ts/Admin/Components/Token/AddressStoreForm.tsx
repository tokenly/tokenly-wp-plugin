import * as React from 'react'
import WalletField from './WalletField'
import { useState } from 'react'

import { 
	TextControl,
	SelectControl,
	Flex,
	CheckboxControl,
} from '@wordpress/components'

interface AddressStoreFormProps {
	storeData: any
	onChange: ( data: any ) => void
}

declare const window: any

export default function AddressStoreForm( props: AddressStoreFormProps ) {
	const [ isWalletAddress, setIsWalletAddress ] = useState<boolean>( false )

	function onAddressFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.address = value
		props.onChange( state )
	}

	function onLabelFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.label = value
		props.onChange( state )
	}

	function onPublicFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.public = value
		props.onChange( state )
	}

	function onTypeFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.type = value
		props.onChange( state )
	}

	function onAddressSelect( value: string ) {
		const state = Object.assign( {}, props.storeData )
		state.address = value
		const isValid = ( value && value != '' )
		if ( isValid ) {
			state.type = 'ethereum'
		}
		props.onChange( state )
		setIsWalletAddress( isValid )
	} 

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { maxWidth: '768px' } }
		>
			<TextControl
				label="Address"
				readOnly={ isWalletAddress }
				help="Bitcoin address to register."
				value={ props.storeData?.address }
				onChange={ onAddressFieldChange }
			/>
		{ window.ethereum &&
			<div>
				<WalletField
					address={ props.storeData?.address }
					onChange={ onAddressSelect }
				/>
			</div>
		}
			<TextControl
				label="Label"
				help="Display label."
				value={ props.storeData?.label }
				onChange={ onLabelFieldChange }
			/>
			<CheckboxControl
				label="Public"
				help="If this address is publicly viewable or not."
				checked={ props.storeData.public }
				onChange={ onPublicFieldChange }
			/>
			<SelectControl
				label="Type"
				value={ props.storeData?.type }
				disabled={ isWalletAddress }
				options={ [
					{
						label: 'Bitcoin',
						value: 'bitcoin',
					},
					{
						label: 'Ethereum',
						value: 'ethereum',
					},
				] }
				onChange={ onTypeFieldChange }
			/>
		</Flex>
	)
}
