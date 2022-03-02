import * as React from 'react';

import { 
	TextControl,
	CheckboxControl,
	SelectControl,
	Flex,
} from '@wordpress/components';

interface AddressEditFormProps {
	onChange: any;
	editData: any;
}

export default function AddressEditForm( props: AddressEditFormProps ) {
	function onAddressFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.address = value;
		props.onChange( state );
	}

	function onLabelFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.label = value;
		props.onChange( state );
	}

	function onPublicFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.public = value;
		props.onChange( state );
	}

	function onTypeFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.type = value;
		props.onChange( state );
	}

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { maxWidth: "320px" } }
		> 
			<TextControl
				label="Address"
				help="Bitcoin address to register."
				value={ props.editData?.address }
				onChange={ onAddressFieldChange }
			/>
			<TextControl
				label="Label"
				help="Display label."
				value={ props.editData?.label }
				onChange={ onLabelFieldChange }
			/>
			<CheckboxControl
				label="Public"
				help="If this address is publicly viewable or not."
				checked={ props.editData.public }
				onChange={ onPublicFieldChange }
			/>
			<SelectControl
				label="Type"
				value={ props.editData?.type }
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
	);
}
