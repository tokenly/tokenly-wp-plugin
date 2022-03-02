import * as React from 'react';
import StatusIndicator from '../../Components/StatusIndicator';
import FormTable from '../FormTable';

import { 
	Flex,
	TextControl,
} from '@wordpress/components';

interface IntegrationSettingsFormProps {
	status: boolean;
	settings: any;
	onChange: any;
}

export default function IntegrationSettingsForm( props: IntegrationSettingsFormProps ) {
	function onClientIdFieldChange( value: any ) {
		let newState = Object.assign( {}, props.settings );
		newState.client_id = value;
		props.onChange( newState );
	}

	function onClientSecretFieldChange( value: any ) {
		let newState = Object.assign( {}, props.settings );
		newState.client_secret = value;
		props.onChange( newState );
	}

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { flex: '1', marginTop: '12px' } }
		> 
			<StatusIndicator status={ props.status ?? false }/>
			<FormTable
				rows={
					[
						{
							label: 'Client ID',
							component:
								<TextControl
									placeholder="Client ID"
									value={ props.settings.client_id ?? '' }
									onChange={ onClientIdFieldChange }
								/>
						},
						{
							label: 'Client Secret',
							component:
								<TextControl
									placeholder="Client Secret"
									value={ props.settings.client_secret ?? '' }
									onChange={ onClientSecretFieldChange }
								/>
						},
					]
				}
			/>
		</Flex>
	);
}
 

