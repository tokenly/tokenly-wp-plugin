import * as React from 'react';
import { Component } from 'react';
import StatusIndicator from '../../Components/StatusIndicator';

import { 
	Flex,
	TextControl,
} from '@wordpress/components';

interface IntegrationSettingsFormProps {
	status: boolean;
	settings: any;
	onChange: any;
}

interface IntegrationSettingsFormState {
	//
}

export default class IntegrationSettingsForm extends Component<IntegrationSettingsFormProps, IntegrationSettingsFormState> {
	constructor( props: IntegrationSettingsFormProps ) {
		super( props );
		this.onClientIdFieldChange = this.onClientIdFieldChange.bind( this );
		this.onClientSecretFieldChange = this.onClientSecretFieldChange.bind( this );
	}

	onClientIdFieldChange( value: any ) {
		let newState = Object.assign( {}, this.props.settings );
		newState.client_id = value;
		this.props.onChange( newState );
	}

	onClientSecretFieldChange( value: any ) {
		let newState = Object.assign( {}, this.props.settings );
		newState.client_secret = value;
		this.props.onChange( newState );
	}

	render() {
		return (
			<Flex
				//@ts-ignore
				direction="column"
				style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
			> 
				<StatusIndicator status={ this.props.status ?? false }/>
				<TextControl
					label="Client ID"
					value={ this.props.settings.client_id ?? '' }
					onChange={ this.onClientIdFieldChange }
				/>
				<TextControl
					label="Client Secret"
					value={ this.props.settings.client_secret ?? '' }
					onChange={ this.onClientSecretFieldChange }
				/>
			</Flex>
		);
	}
}
 

