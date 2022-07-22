import * as React from 'react'

import { 
	TextControl,
} from '@wordpress/components'
import AssetInterface from '../../../Interfaces/Models/Token/AssetInterface'

interface AssetFieldProps {
	label?: string
	asset: AssetInterface
	onChange: ( data: any ) => void
}

export default function AssetField( props: AssetFieldProps ) {
	function onAddressFieldChange( value: string ) {
		const state = Object.assign( {}, props.asset )
		state.address = value
		props.onChange( state )
	}

	function onIndexFieldChange( value: string ) {
		const state = Object.assign( {}, props.asset )
		state.index = value
		props.onChange( state )
	}

	return (
		<fieldset style={ { border: '1px solid #dcdcde', padding: '12px' } }>
			<legend>{ props.label }</legend>
			<div 
				style={ {
					display: 'grid',
					gridGap: '12px',
					gridTemplateColumns: '1fr 1fr'
				} }
			>
				<TextControl
					value={ props.asset.address }
					label="Contract Address"
					onChange={ onAddressFieldChange }
				/>
				<TextControl
					value={ props.asset.index }
					label="Token Index"
					onChange={ onIndexFieldChange }
				/>
			</div>
		</fieldset>
	)
}
 

