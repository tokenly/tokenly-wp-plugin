import * as React from 'react';

import { 
	TextControl,
	TextareaControl,
	Flex,
} from '@wordpress/components';

interface PromiseEditFormProps {
	onChange: any;
	editData: any;
}

export default function PromiseEditForm( props: PromiseEditFormProps ) {
	function onQuantityFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.quantity.value_sat = value;
		props.onChange( state );
	}

	function onTxidFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.txid = value;
		props.onChange( state );
	}

	function onFingerprintFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.fingerprint = value;
		props.onChange( state );
	}

	function onReferenceFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.ref = value;
		props.onChange( state );
	}

	function onNoteFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.note = value;
		props.onChange( state );
	}

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { maxWidth: "320px" } }
		> 
			<TextControl
				label="Quantity *"
				help="Amount, in satoshis."
				type="number"
				value={ props.editData?.quantity?.value_sat }
				onChange={ onQuantityFieldChange }
				required
			/>
			<TextControl
				label="TXID"
				help="Transaction ID of the real bitcoin transaction in-flight."
				value={ props.editData?.txid }
				onChange={ onTxidFieldChange }
			/>
			<TextControl
				label="Fingerprint"
				help="XChain transaction fingerprint of the real btc tx."
				value={ props.editData?.fingerprint }
				onChange={ onFingerprintFieldChange }
			/>
			<TextareaControl
				label="Reference"
				help="Extra reference data."
				value={ props.editData?.ref }
				onChange={ onReferenceFieldChange }
			/>
			<TextareaControl
				label="Note"
				help="Note to display to user."
				value={ props.editData?.note }
				onChange={ onNoteFieldChange }
			/>
		</Flex>
	);
}
