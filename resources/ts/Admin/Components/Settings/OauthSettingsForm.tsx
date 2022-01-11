import * as React from 'react';
import { Component } from 'react';
import { OauthSettings } from '../../../Interfaces';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
	TextControl,
	ToggleControl,
} from '@wordpress/components';

interface OauthSettingsFormProps {
	settings: OauthSettings;
	onChange: any;
}

interface OauthSettingsFormState {
	//
}

export default class OauthSettingsForm extends Component<OauthSettingsFormProps, OauthSettingsFormState> {
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: OauthSettingsFormProps ) {
		super( props );
		this.onRedirectUrlFieldChange = this.onRedirectUrlFieldChange.bind( this );
		this.onSsoFieldChange = this.onSsoFieldChange.bind( this );
		this.onAllowNoEmailFieldChange = this.onAllowNoEmailFieldChange.bind( this );
		this.onAllowUnconfirmedEmailFieldChange = this.onAllowUnconfirmedEmailFieldChange.bind( this );
	}

	onRedirectUrlFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.settings );
		newState.success_url = value;
		this.props.onChange( newState );
	}

	onSsoFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.settings );
		newState.use_single_sign_on = value;
		this.props.onChange( newState );
	}

	onAllowNoEmailFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.settings );
		newState.allow_no_email = value;
		this.props.onChange( newState );
	}

	onAllowUnconfirmedEmailFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.settings );
		newState.allow_unconfirmed_email = value;
		this.props.onChange( newState );
	}

	render() {
		return (
			<Flex
				//@ts-ignore
				direction="column"
			>
				<TextControl
					label="Redirect URL"
					value={ this.props.settings.success_url }
					help="Default redirect URL on success for the login shortcode and the main login form."
					placeholder={ `/${ this.namespace }/user/me/` }
					onChange={ this.onRedirectUrlFieldChange }
				/>
				<ToggleControl
					label="Use Single Sign-On (SSO)"
					help="Allows the existing users to login using their Tokenpass account."
					checked={ this.props.settings.use_single_sign_on }
					onChange={ this.onSsoFieldChange }
				/>
				<ToggleControl
					label="Allow Accounts Without Email"
					help="Allows connecting Tokenpass accounts which have no email accounts associated."
					checked={ this.props.settings.allow_no_email }
					onChange={ this.onAllowNoEmailFieldChange }
				/>
				<ToggleControl
					label="Allow Accounts Without a Confirmed Email"
					help="Allow connecting Tokenpass accounts which have an unconfirmed email account associated."
					checked={ this.props.settings.allow_unconfirmed_email }
					onChange={ this.onAllowUnconfirmedEmailFieldChange }
				/>
			</Flex>
		);
	}
}
 

