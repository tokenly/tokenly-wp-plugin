import * as React from 'react';
import { Component } from 'react';
import { PromiseStoreData } from '../../repositories/PromiseRepository';
import { UserSearchField } from './UserSearchField';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
} from '@wordpress/components';

interface PromiseStoreFormProps {
	saving: boolean;
	onSubmit: any;
	style: any;
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
	
	onUserChange( userId: number ) {
		const promise = Object.assign( {}, this.state.promise );
		promise.destination = userId;
		this.setState( { promise: promise } );
	}

	render() {
		return <div>
			<form>
				<div>
					<UserSearchField
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.destination = value;
							this.setState( { promise: state } );
						} }
					/>
				</div>
				<div style={{maxWidth: "320px"}}>
					<TextControl
						label="Source address"
						value={ this.state.promise.source }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.source = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextControl
						label="Asset ID"
						value={ this.state.promise.asset }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.asset = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextControl
						label="Quantity"
						type="number"
						value={ this.state.promise.quantity }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.quantity = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextControl
						label="Ref"
						value={ this.state.promise.ref }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.ref = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextareaControl
						label="Note"
						value={ this.state.promise.note }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.note = value;
							this.setState( { promise: state } );
						} }
					/>
					<Button
						isPrimary
						isLarge
						disabled={ this.props.saving }
						onClick={ () => {
							this.onPromiseSubmit();
						}}
						style={ { marginTop: '12px' } }
					>
						Create transaction
					</Button>
					{this.props.saving === true &&
						<Spinner/>
					}
				</div>
			</form>
		</div>
	}
}
