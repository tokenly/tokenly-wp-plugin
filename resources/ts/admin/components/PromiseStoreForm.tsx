import * as React from 'react';
import { Component } from 'react';
import { PromiseStoreParams, SourceItem } from '../../interfaces';
import { UserSearchField } from './UserSearchField';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
	SelectControl
} from '@wordpress/components';

interface PromiseStoreFormProps {
	saving: boolean;
	onSubmit: any;
	style: any;
	sources: Array<SourceItem>;
}

interface PromiseStoreFormState {
	promise: PromiseStoreParams;
	sources: Array<string>;
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
		sources: [],
	};
	constructor( props: PromiseStoreFormProps ) {
		super( props );
		this.onPromiseSubmit = this.onPromiseSubmit.bind( this );
		this.onUserChange = this.onUserChange.bind( this );
		this.state.sources = this.props.sources.map( source => {
			return {
				label: source.address,
				value: source.address,
			} as any
		} );
		const defaultSource: any = this.state.sources[0] ?? null;
		if ( defaultSource ) {
			this.state.promise.source = defaultSource?.value ?? null;
		}
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
		return (
			<form style={{width: '100%', maxWidth: '320px'}}>
				<div>
					<UserSearchField
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.destination = value;
							this.setState( { promise: state } );
						} }
					/>
				</div>
				<div>
					<SelectControl
						label="Source address"
						value={ this.state.promise.source }
						options={ this.state.sources as any }
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
		);
	}
}
