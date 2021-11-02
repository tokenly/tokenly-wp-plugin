import * as React from 'react';
import { Component } from 'react';
import { SourceStoreParams } from '../../interfaces';

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
}

interface SourceStoreFormState {
	source: SourceStoreParams;
}

export class SourceStoreForm extends Component<SourceStoreFormProps, SourceStoreFormState> {
	state: SourceStoreFormState = {
		source: {
			address: null,
			assets: null,
			type: null,
		},
	};
	
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
	}
	
	onSubmit() {
		this.props.onSubmit( this.state.source );
	}

	onCancel() {
		this.props.onCancel();
	}

	isSubmitDisabled() {
		if (
			this.state.source.type != null &&
			this.state.source.address != ''
		) {
			return false;
		}
		return true;
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "320px" } }>
				<div>
					<SelectControl
						label="Type"
						value={ this.state.source.type }
						style={{width: '100%'}}
						options={ [
							{ label: null, value: null },
							{ label: 'Bitcoin', value: 'bitcoin' },
							{ label: 'Ethereum', value: 'ethereum' },
						] }
						help="Source blockchain type"
						onChange={ ( value: string ) => {
							const state = Object.assign( {}, this.state.source );
							state.type = value;
							this.setState( { source: state } );
						} }
					/>
					{ this.state.source.type &&
						<div>
							<TextControl
								label="Address"
								value={ this.state.source.address }
								help="Wallet address"
								onChange={ (value: any) => {
									const state = Object.assign( {}, this.state.source );
									state.address = value;
									this.setState( { source: state } );
								} }
							/>
							<TextControl
								label="Assets"
								help="Comma-separated values"
								value={ this.state.source.assets }
								onChange={ ( value: any ) => {
									const state = Object.assign( {}, this.state.source );
									state.assets = value;
									this.setState( { source: state } );
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
							disabled={ this.isSubmitDisabled() }
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
