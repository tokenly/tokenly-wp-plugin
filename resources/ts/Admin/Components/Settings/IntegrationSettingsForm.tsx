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
		this.onChange = this.onChange.bind( this );
	}

	onChange( newSettings: any ) {
		this.props.onChange( newSettings );
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
					onChange={ ( value: string ) => {
							let newSettings = Object.assign( {}, this.props.settings );
							newSettings.client_id = value;
							this.onChange( newSettings );
						}
					}
				/>
				<TextControl
					label="Client Secret"
					value={ this.props.settings.client_secret ?? '' }
					onChange={ ( value: string ) => {
							let newSettings = Object.assign( {}, this.props.settings );
							newSettings.client_secret = value;
							this.onChange( newSettings );
						}
					}
				/>
			</Flex>
		);
	}
}
 

