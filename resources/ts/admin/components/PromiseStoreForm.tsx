import * as React from 'react';
import { Component } from 'react';
import { PromiseStoreData } from '../../repositories/PromiseRepository';
import { UserSearchField } from './UserSearchField';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
	Spinner,
	TextControl,
	TextareaControl,
} = wp.components;

interface PromiseStoreFormProps {
	saving: boolean;
	onSubmit: any;
}

interface PromiseStoreFormState {
	promise: PromiseStoreData;
}

export class PromiseStoreForm extends Component<PromiseStoreFormProps, PromiseStoreFormState> {
	state: PromiseStoreFormState = {
		promise: {
			source: null,
			destination: null,
			asset: null,
			quantity: 1,
			ref: null,
			note: null,
		},
	};
	constructor( props: PromiseStoreFormProps ) {
		super( props );
		this.onPromiseSubmit = this.onPromiseSubmit.bind( this );
		this.onUserChange = this.onUserChange.bind( this );
	}
	
	onPromiseSubmit() {
		this.props.onSubmit( this.state.promise );
	}
	
	onUserChange( user: string ) {
		const promise = Object.assign( {}, this.state.promise );
		promise.destination = user;
		this.setState( { promise: promise } );
	}

	render() {
		return <div>
			<form style={{maxWidth: "500px"}}>
				<TextControl
					label="User"
					value={ this.state.promise.destination }
					onChange={ (value: any) => {
						const state = Object.assign( {}, this.state.promise );
						state.destination = value;
						this.setState( { promise: state } );
					} }
					
				/>
				<TextControl
					label="Source address"
					value={ this.state.promise.source }
				/>
				<TextControl
					label="Asset ID"
					value={ this.state.promise.asset }
				/>
				<TextControl
					label="Quantity"
					type="number"
					value={ this.state.promise.quantity }
				/>
				<TextControl
					label="Ref"
					value={ this.state.promise.ref }
				/>
				<TextareaControl
					label="Note"
					value={ this.state.promise.note }
				/>
				<Button
					isPrimary
					isLarge
					disabled={ this.props.saving }
					onClick={ () => {
						this.onPromiseSubmit();
					}}
				>
					{ __( 'Create transaction' ) }
				</Button>
					{this.props.saving === true &&
							<Spinner/>
					}
			</form>
		</div>
	}
}