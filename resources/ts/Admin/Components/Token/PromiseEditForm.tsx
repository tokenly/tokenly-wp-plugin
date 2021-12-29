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
	loading: boolean;
	editData: any;
}

interface PromiseEditFormState {
	//
}

export default class PromiseEditForm extends Component<PromiseEditFormProps, PromiseEditFormState> {
	state: PromiseEditFormState = {
		//
	};
	constructor( props: PromiseEditFormProps ) {
		super( props );
	}

	render() {
		return (
			<form style={{width: '100%'}}>
				<Disabled
					//@ts-ignore
					isDisabled={ this.props.loading }
				>
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
							value={ this.props.editData?.quantity }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.props.editData );
								state.quantity = value;
								this.props.onChange( state );
							} }
						/>
						<TextControl
							label="TXID"
							// @ts-ignore
							hint="Transaction ID of the real bitcoin transaction in-flight"
							value={ this.props.editData?.txid }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.props.editData );
								state.txid = value;
								this.props.onChange( state );
							} }
						/>
						<TextControl
							label="Fingerprint"
							// @ts-ignore
							hint="XChain transaction fingerprint of the real btc tx"
							value={ this.props.editData?.fingerprint }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.props.editData );
								state.fingerprint = value;
								this.props.onChange( state );
							} }
						/>
						<TextareaControl
							label="Ref"
							// @ts-ignore
							hint="Extra reference data"
							value={ this.props.editData?.ref }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.props.editData );
								state.ref = value;
								this.props.onChange( state );
							} }
						/>
						<TextareaControl
							label="Note"
							// @ts-ignore
							hint="Note to display to user"
							value={ this.props.editData?.note }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.props.editData );
								state.note = value;
								this.props.onChange( state );
							} }
						/>
					</Flex>
				</Disabled>
			</form>
		);
	}
}
