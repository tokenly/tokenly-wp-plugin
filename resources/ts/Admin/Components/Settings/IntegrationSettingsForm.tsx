import * as React from 'react'
import StatusIndicator from '../../Components/StatusIndicator'
import FormTable from '../FormTable'
import IntegrationSettings from '../../../Models/Settings/IntegrationSettings'
import IntegrationSettingsInterface from '../../../Interfaces/Models/Settings/IntegrationSettingsInterface'

import { 
	Flex,
	TextControl,
} from '@wordpress/components'

interface IntegrationSettingsFormProps {
	status: boolean
	settings: IntegrationSettingsInterface
	onChange: any
}

export default function IntegrationSettingsForm( props: IntegrationSettingsFormProps ) {
	function onClientIdFieldChange( value: any ) {
		let newState = Object.assign( new IntegrationSettings(), props.settings )
		newState.clientId = value
		props.onChange( newState )
	}

	function onClientSecretFieldChange( value: any ) {
		let newState = Object.assign( new IntegrationSettings(), props.settings )
		newState.clientSecret = value
		props.onChange( newState )
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
									value={ props.settings.clientId ?? '' }
									onChange={ onClientIdFieldChange }
								/>
						},
						{
							label: 'Client Secret',
							component:
								<TextControl
									placeholder="Client Secret"
									value={ props.settings.clientSecret ?? '' }
									onChange={ onClientSecretFieldChange }
								/>
						},
					]
				}
			/>
		</Flex>
	)
}
 

