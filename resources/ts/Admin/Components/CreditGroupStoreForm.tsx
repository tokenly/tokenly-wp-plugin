import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	TextControl,
	SelectControl,
	Flex,
	TextareaControl,
} from '@wordpress/components';

interface CreditGroupStoreFormProps {
	saving: boolean;
	onSubmit: any;
	onCancel: any;
	onChange?: any;
	style: any;
}

interface CreditGroupStoreFormState {
	name: string;
	appWhitelist: string;
}

export class CreditGroupStoreForm extends Component<CreditGroupStoreFormProps, CreditGroupStoreFormState> {
	state: CreditGroupStoreFormState = {
		name: null,
		appWhitelist: null,
	};
	
	constructor( props: CreditGroupStoreFormProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
	}
	
	onSubmit() {
		this.props.onSubmit( {
			name: this.state.name,
			app_whitelist: this.state.appWhitelist,
		} );
	}

	onCancel() {
		this.props.onCancel();
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<div>
					<Flex
						//@ts-ignore
						direction="column"
					>
						<TextControl
							label="Name"
							value={ this.state.name }
							onChange={ (value: any) => {
								this.setState( { name: value } );
							} }
						/>
						<TextareaControl
							label="App whitelist"
							value={ this.state.appWhitelist }
							help="Comma-separated list."
							onChange={ ( value: any ) => {
								this.setState( { appWhitelist: value } );
							} }
						/>
					</Flex>
					<Flex
						style={ { marginTop: '12px' } }
						justify="flex-start"
					>
						<Button
							isPrimary 
							disabled={ this.state.name === null }
							onClick={ () => {
								this.onSubmit();
							}}
						>
							Register credit group
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