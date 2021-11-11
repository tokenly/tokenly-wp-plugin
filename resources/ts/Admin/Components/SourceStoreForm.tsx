import * as React from 'react';
import { Component } from 'react';
import { SourceStoreParams } from '../../Interfaces';

import { 
	Button,
	Spinner,
	TextControl,
	SelectControl,
	Flex,
} from '@wordpress/components';

interface SourceStoreFormProps {
	saving: boolean;
	onSubmit: any;
	onCancel: any;
	style: any;
	addresses: Array<any>,
}

interface SourceStoreFormState {
	address: string;
	assets: string;
	addressOptions: Array<any>;
	
}

export class SourceStoreForm extends Component<SourceStoreFormProps, SourceStoreFormState> {
	state: SourceStoreFormState = {
		address: null,
		assets: null,
		addressOptions: [],
	};
	
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
		this.state.addressOptions = this.props.addresses.map( ( address ) => {
			return {
				'label': address.label,
				'value': address.address,
			}
		} );
		console.log(this.props.addresses);
	}

	componentDidMount() {
		if ( this.state.addressOptions[0] ) {
			this.setState( { address: this.state.addressOptions[0].value } );
		}
		console.log(this.state);
	}
	
	onSubmit() {
		const selectedAddress = this.props.addresses.find( address => {
			return address.address === this.state.address;
		} )
		if ( !selectedAddress ) {
			return;
		}
		const source = {
			address: selectedAddress.address,
			type: selectedAddress.type,
			assets: this.state.assets,
		}		
		this.props.onSubmit( source );
	}

	onCancel() {
		this.props.onCancel();
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "320px" } }>
				<div>
					<SelectControl
						label="Address"
						value={ this.state.address }
						style={{width: '100%'}}
						options={ this.state.addressOptions }
						help="Address for registration"
						onChange={ ( value: any ) => {
							this.setState( { address: value } );
						} }
					/>
					{ this.state?.address &&
						<div>
							<TextControl
								label="Assets"
								help="Comma-separated values"
								value={ this.state.assets }
								onChange={ ( value: any ) => {
									// const state = Object.assign( {}, this.state.source );
									// state.assets = value;
									// this.setState( { source: state } );
								} }
							/>
						</div>
					}
					<Flex
						style={ { marginTop: '12px' } }
						justify="flex-start"
					>
						<Button
							isPrimary
							disabled={ !this.state?.address }
							onClick={ () => {
								this.onSubmit();
							}}
						>
							Register source
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
							
						>
							Cancel
						</Button>
						{this.props.saving === true &&
							<Spinner/>
						}
					</Flex>
				</div>
			</form>
		);
	}
}
