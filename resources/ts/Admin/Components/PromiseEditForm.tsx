import * as React from 'react';
import { Component } from 'react';
import { PromiseData, PromiseUpdateParams } from '../../Interfaces';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
	Flex,
} from '@wordpress/components';

interface PromiseEditFormProps {
	saving: boolean;
	deleting: boolean;
	onSave: any;
	onDelete: any;
	onCancel: any;
	promise: PromiseData;
}

interface PromiseEditFormState {
	promise: PromiseUpdateParams;
}

export class PromiseEditForm extends Component<PromiseEditFormProps, PromiseEditFormState> {
	state: PromiseEditFormState = {
		promise: {} as any,
	};
	constructor( props: PromiseEditFormProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onDelete = this.onDelete.bind( this );
		this.onCancel = this.onCancel.bind( this );
		this.state.promise = {
			quantity: this.props.promise?.quantity?.value_sat,
			expiration: null,
			txid: null,
			fingerprint: null,
			ref: this.props.promise.ref,
			note: this.props.promise.note,
		};
	}
	
	onSave() {
		this.props.onSave( this.state.promise );
	}

	onDelete() {
		this.props.onDelete();
	}

	onCancel() {
		this.props.onCancel();
	}

	render() {
		return (
			<form style={{width: '100%'}}>
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
						value={ this.state.promise.quantity }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.quantity = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextControl
						label="TXID"
						// @ts-ignore
						hint="Transaction ID of the real bitcoin transaction in-flight"
						value={ this.state.promise.txid }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.txid = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextControl
						label="Fingerprint"
						// @ts-ignore
						hint="XChain transaction fingerprint of the real btc tx"
						value={ this.state.promise.fingerprint }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.fingerprint = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextareaControl
						label="Ref"
						// @ts-ignore
						hint="Extra reference data"
						value={ this.state.promise.ref }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.ref = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextareaControl
						label="Note"
						// @ts-ignore
						hint="Note to display to user"
						value={ this.state.promise.note }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.note = value;
							this.setState( { promise: state } );
						} }
					/>
				</Flex>
				<Flex justify="flex-start" align="center" style={ { marginTop: '12px' } }>
					<Button
						isPrimary
						disabled={ this.props.saving }
						onClick={ () => {
							this.onSave();
						}}
					>
						Save promise
					</Button>
					{ this.props.saving === true &&
						<Spinner/>
					}
					<Button
						isSecondary
						disabled={ this.props.deleting }
						onClick={ () => {
							this.onDelete();
						}}
					>
						Delete promise
					</Button>
					{ this.props.deleting === true &&
						<Spinner/>
					}
					<Button
						isTertiary
						disabled={ this.props.deleting }
						onClick={ () => {
							this.onCancel();
						}}
					>
						Cancel
					</Button>
				</Flex>
			</form>
		);
	}
}
