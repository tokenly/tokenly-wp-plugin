import * as React from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import FormTable from '../FormTable'
import OauthSettings from '../../../Models/Settings/OauthSettings'
import OauthSettingsInterface from '../../../Interfaces/Models/Settings/OauthSettingsInterface'

import { 
	TextControl,
	ToggleControl,
} from '@wordpress/components'

interface OauthSettingsFormProps {
	settings: OauthSettingsInterface
	onChange: any
}

export default function OauthSettingsForm( props: OauthSettingsFormProps ) {
	const brand = useInjection( TYPES.Variables.brand )
	const namespace = useInjection( TYPES.Variables.namespace )

	function onRedirectUrlFieldChange( value: any ) {
		const newState = Object.assign( new OauthSettings(), props.settings )
		newState.successUrl = value
		props.onChange( newState )
	}

	function onSsoFieldChange( value: any ) {
		const newState = Object.assign( new OauthSettings(), props.settings )
		newState.useSingleSignOn = value
		props.onChange( newState )
	}

	function onAllowNoEmailFieldChange( value: any ) {
		const newState = Object.assign( new OauthSettings(), props.settings )
		newState.allowNoEmail = value
		props.onChange( newState )
	}

	function onAllowUnconfirmedEmailFieldChange( value: any ) {
		const newState = Object.assign( new OauthSettings(), props.settings )
		newState.allowUnconfirmedEmail = value
		props.onChange( newState )
	}

	return (
		<FormTable
		rows={
			[
				{
					label: 'Redirect URL',
					component:
						<TextControl
							value={ props.settings.successUrl }
							help="Default redirect URL on success for the login shortcode and the main login form."
							placeholder={ `/${ namespace }/user/me/` }
							onChange={ onRedirectUrlFieldChange }
						/>
				},
				{
					label: 'SSO',
					component:
						<ToggleControl
							label="Use Single Sign-On (SSO)"
							help={ `Allows the existing users to login using their ${brand} account.` }
							checked={ props.settings.useSingleSignOn }
							onChange={ onSsoFieldChange }
						/>
				},
				{
					label: 'Accounts Without Email',
					component:
						<ToggleControl
							label="Allow Accounts Without Email"
							help={ `Allows connecting ${brand} accounts which have no email accounts associated.` }
							checked={ props.settings.allowNoEmail }
							onChange={ onAllowNoEmailFieldChange }
						/>
				},
				{
					label: 'Accounts Without a Confirmed Email',
					component:
						<ToggleControl
							label="Allow Accounts Without a Confirmed Email"
							help={ `Allows connecting ${brand} accounts which have an unconfirmed email account associated.` }
							checked={ props.settings.allowUnconfirmedEmail }
							onChange={ onAllowUnconfirmedEmailFieldChange }
						/>
				},
			]
		}
	/>
	)
}
 

