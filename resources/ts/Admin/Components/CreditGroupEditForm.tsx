import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
	Flex,
} from '@wordpress/components';

interface CreditGroupEditFormProps {
	saving: boolean;
	onSave: any;
	onCancel: any;
	creditGroup: any;
}

interface CreditGroupEditFormState {
	creditGroup: any;
}

export class CreditGroupEditForm extends Component<CreditGroupEditFormProps, CreditGroupEditFormState> {
	state: CreditGroupEditFormState = {
		creditGroup: {
			name: null,
			app_whitelist: null,
		},
	};
	constructor( props: CreditGroupEditFormProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.state.creditGroup = Object.assign( this.state.creditGroup, this.props.creditGroup );
	}
	
	onSave() {
		this.props.onSave( this.state.creditGroup );
	}

	onCancel() {
		this.props.onCancel();
	}

	render() {
		return <div>
			<form>
				<div style={{maxWidth: "320px"}}>
					<Flex
						//@ts-ignore
						direction="column"
					>
						<TextControl
							label="Name"
							value={ this.state.creditGroup.name }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.state.creditGroup );
								state.name = value;
								this.setState( { creditGroup: state } );
							} }
						/>
						<TextareaControl
							label="App whitelist"
							help="Comma-separated values."
							value={ this.state.creditGroup.app_whitelist }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.state.creditGroup );
								state.app_whitelist = value;
								this.setState( { creditGroup: state } );
							} }
						/>
					</Flex>
					<Flex justify="flex-start" style={ { marginTop: '12px' } }>
						<Button
							isPrimary
							disabled={ this.props.saving }
							onClick={ () => {
								this.onSave();
							}}
						>
							Save credit group
						</Button>
						<Button
							isTertiary
							onClick={ () => {
								this.onCancel();
							}}
						>
							Cancel
						</Button>
					</Flex>
				</div>
			</form>
		</div>
	}
}
