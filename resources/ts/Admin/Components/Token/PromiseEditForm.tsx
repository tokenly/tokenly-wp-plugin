import * as React from 'react';
import { Component } from 'react';

import { 
	TextControl,
	TextareaControl,
	Flex,
	Disabled,
} from '@wordpress/components';

interface PromiseEditFormProps {
	onChange: any;
	editData: any;
}

export default function PromiseEditForm( props: PromiseEditFormProps ) {
	return (
		<form style={ { width: '100%' } }>
			<Flex
				//@ts-ignore
				direction="column"
				style={ { maxWidth: "320px" } }
			> 
				<TextControl
					label="Quantity"
					// @ts-ignore
					hint="Amount, in satoshis"
					type="number"
					value={ props.editData?.quantity }
					onChange={ (value: any) => {
						const state = Object.assign( {}, props.editData );
						state.quantity = value;
						props.onChange( state );
					} }
				/>
				<TextControl
					label="TXID"
					// @ts-ignore
					hint="Transaction ID of the real bitcoin transaction in-flight"
					value={ props.editData?.txid }
					onChange={ (value: any) => {
						const state = Object.assign( {}, props.editData );
						state.txid = value;
						props.onChange( state );
					} }
				/>
				<TextControl
					label="Fingerprint"
					// @ts-ignore
					hint="XChain transaction fingerprint of the real btc tx"
					value={ props.editData?.fingerprint }
					onChange={ (value: any) => {
						const state = Object.assign( {}, props.editData );
						state.fingerprint = value;
						props.onChange( state );
					} }
				/>
				<TextareaControl
					label="Reference"
					// @ts-ignore
					hint="Extra reference data"
					value={ props.editData?.ref }
					onChange={ (value: any) => {
						const state = Object.assign( {}, props.editData );
						state.ref = value;
						props.onChange( state );
					} }
				/>
				<TextareaControl
					label="Note"
					// @ts-ignore
					hint="Note to display to user"
					value={ props.editData?.note }
					onChange={ (value: any) => {
						const state = Object.assign( {}, props.editData );
						state.note = value;
						props.onChange( state );
					} }
				/>
			</Flex>
		</form>
	);
}
