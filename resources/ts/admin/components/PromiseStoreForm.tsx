import * as React from 'react';
import { Component } from 'react';
import { PromiseStoreParams, SourceItem } from '../../Interfaces';
import { UserSearchField } from './UserSearchField';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
	SelectControl,
	Flex,
} from '@wordpress/components';

interface PromiseStoreFormProps {
	saving: boolean;
	onSubmit: any;
	onCancel: any;
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
		this.onSubmit = this.onSubmit.bind( this );
		this.onCancel = this.onCancel.bind( this );
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
	
	onSubmit() {
		this.props.onSubmit( this.state.promise );
	}

	onCancel() {
		this.props.onCancel( this.state.promise );
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
						help="Token to promise"
						value={ this.state.promise.asset }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.asset = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextControl
						label="Quantity"
						help="Amount, in satoshis"
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
						help="Extra reference data"
						value={ this.state.promise.ref }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.ref = value;
							this.setState( { promise: state } );
						} }
					/>
					<TextareaControl
						label="Note"
						help="Note to display to user"
						value={ this.state.promise.note }
						onChange={ (value: any) => {
							const state = Object.assign( {}, this.state.promise );
							state.note = value;
							this.setState( { promise: state } );
						} }
					/>
					<Flex justify="flex-start">
						<Button
							isPrimary
							disabled={ this.props.saving }
							onClick={ () => {
								this.onSubmit();
							}}
							style={ { marginTop: '12px' } }
						>
							Create transaction
						</Button>
						{this.props.saving === true &&
							<Spinner/>
						}
						<Button
							isTertiary
							disabled={ this.props.saving }
							onClick={ () => {
								this.onCancel();
							}}
							style={ { marginTop: '12px' } }
						>
							Cancel
						</Button>
					</Flex>
				</div>
			</form>
		);
	}
}
