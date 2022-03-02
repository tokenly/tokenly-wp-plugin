import * as React from 'react';
import { OauthSettings } from '../../../Interfaces';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import FormTable from '../FormTable';

import { 
	TextControl,
	ToggleControl,
} from '@wordpress/components';

interface OauthSettingsFormProps {
	settings: OauthSettings;
	onChange: any;
}

export default function OauthSettingsForm( props: OauthSettingsFormProps ) {
	const brand = useInjection( TYPES.Variables.brand );
	const namespace = useInjection( TYPES.Variables.namespace );

	function onRedirectUrlFieldChange( value: any ) {
		const newState = Object.assign( {}, props.settings );
		newState.success_url = value;
		props.onChange( newState );
	}

	function onSsoFieldChange( value: any ) {
		const newState = Object.assign( {}, props.settings );
		newState.use_single_sign_on = value;
		props.onChange( newState );
	}

	function onAllowNoEmailFieldChange( value: any ) {
		const newState = Object.assign( {}, props.settings );
		newState.allow_no_email = value;
		props.onChange( newState );
	}

	function onAllowUnconfirmedEmailFieldChange( value: any ) {
		const newState = Object.assign( {}, props.settings );
		newState.allow_unconfirmed_email = value;
		props.onChange( newState );
	}

	return (
		<FormTable
		rows={
			[
				{
					label: 'Redirect URL',
					component:
						<TextControl
							value={ props.settings.success_url }
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
							checked={ props.settings.use_single_sign_on }
							onChange={ onSsoFieldChange }
						/>
				},
				{
					label: 'Accounts Without Email',
					component:
						<ToggleControl
							label="Allow Accounts Without Email"
							help={ `Allows connecting ${brand} accounts which have no email accounts associated.` }
							checked={ props.settings.allow_no_email }
							onChange={ onAllowNoEmailFieldChange }
						/>
				},
				{
					label: 'Accounts Without a Confirmed Email',
					component:
						<ToggleControl
							label="Allow Accounts Without a Confirmed Email"
							help={ `Allows connecting ${brand} accounts which have an unconfirmed email account associated.` }
							checked={ props.settings.allow_unconfirmed_email }
							onChange={ onAllowUnconfirmedEmailFieldChange }
						/>
				},
			]
		}
	/>
	);
}
 

