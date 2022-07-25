import * as React from 'react'
import StatusIndicator from '../../Components/StatusIndicator'
import FormTable from '../FormTable'
import IntegrationSettings from '../../../Models/Settings/IntegrationSettings'
import IntegrationSettingsInterface
	from '../../../Interfaces/Models/Settings/IntegrationSettingsInterface'
import { TYPES, ApiScope } from '../../../Types'
import { useInjection } from 'inversify-react'

import { 
	Flex,
	TextControl,
	ToggleControl
} from '@wordpress/components'

interface IntegrationSettingsFormProps {
	status: boolean
	settings: IntegrationSettingsInterface
	onChange: ( newSettings: any ) => void
}

export default function IntegrationSettingsForm(
	props: IntegrationSettingsFormProps
) {
	const dictionary: any = useInjection( TYPES.Variables.dictionary )

	function onClientIdFieldChange( value: any ) {
		let newState = Object.assign(
			new IntegrationSettings(), props.settings
)
		newState.clientId = value
		props.onChange( newState )
	}

	function onClientSecretFieldChange( value: any ) {
		let newState = Object.assign(
			new IntegrationSettings(), props.settings
		)
		newState.clientSecret = value
		props.onChange( newState )
	}

	function addOrRemove( array: Array<string>, value: string ) {
		var index = array.indexOf( value );
		if ( index === -1 ) {
			array.push( value )
		} else {
			array.splice( index, 1 )
		}
	}

	function onPrivateBalancesFieldChange() {
		let newState = Object.assign(
			new IntegrationSettings(), props.settings
		)
		const scopes = Object.assign( [], newState.extraScopes )
		addOrRemove( scopes, ApiScope.PrivateBalances )
		newState.extraScopes = scopes
		props.onChange( newState )
	}

	function onPrivateAddressesFieldChange() {
		let newState = Object.assign(
			new IntegrationSettings(), props.settings
		)
		const scopes = Object.assign( [], newState.extraScopes )
		addOrRemove( scopes, ApiScope.PrivateAddress )
		newState.extraScopes = scopes
		props.onChange( newState )
	}

	function isScopeEnabled( scope: ApiScope ): boolean {
		return ( props.settings?.extraScopes?.includes( scope ) )
	}

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { flex: '1', marginTop: '12px' } }
		> 
			<StatusIndicator status={ props.status ?? false }/>
			<FormTable rows={ [
				{
					label: dictionary.get(
						'settingsIntegrationClientIdLabel'
					),
					component:
						<TextControl
							placeholder="Client ID"
							value={ props.settings.clientId ?? '' }
							onChange={ onClientIdFieldChange }
						/>
				},
				{
					label: dictionary.get(
						'settingsIntegrationClientSecretLabel'
					),
					component:
						<TextControl
							value={ props.settings.clientSecret ?? '' }
							onChange={ onClientSecretFieldChange }
						/>
				}
			] } />
			<div>
				<hr></hr>
				<div>
					<b>
						{ dictionary.get(
							'settingsIntegrationScopesTitle'
						) }
					</b>
				</div>
				<div>
					{ dictionary.get(
						'settingsIntegrationScopesDescription'
					) }
				</div>
			</div>
			<FormTable rows={ [
				{
					label: dictionary.get(
						'settingsIntegrationScopesPrivateBalancesTitle'
					),
					component: 
						<ToggleControl
							label={ dictionary.get(
								'settingsIntegrationScopesPrivateBalancesLabel'
							) }
							help={ dictionary.get(
								'settingsIntegrationScopesPrivateBalancesDescription'
							) }
							checked={
								isScopeEnabled( ApiScope.PrivateBalances )
							}
							onChange={ onPrivateBalancesFieldChange }
						/>
				},
				{
					label: dictionary.get(
						'settingsIntegrationScopesPrivateAddressesTitle'
					),
					component: 
						<ToggleControl
							label={ dictionary.get(
								'settingsIntegrationScopesPrivateAddressesLabel'
							) }
							help={ dictionary.get(
								'settingsIntegrationScopesPrivateAddressesDescription'
							) }
							checked={
								isScopeEnabled( ApiScope.PrivateAddress )
							}
							onChange={ onPrivateAddressesFieldChange }
						/>
				}
			] } />
		</Flex>
	)
}
 

