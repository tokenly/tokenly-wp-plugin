import * as React from 'react';
import { Component } from 'react';
import { OauthSettings } from '../../../Interfaces';

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

export class OauthSettingsForm extends Component<OauthSettingsFormProps, OauthSettingsFormState> {

	constructor( props: OauthSettingsFormProps ) {
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
			>
				<TextControl
					label="Redirect URL"
					value={ this.props.settings.success_url }
					help="Default redirect URL on success for the login shortcode and the main login form."
					placeholder="/tokenly/user/me/"
					onChange={ ( value ) => {
						const state = Object.assign( {}, this.props.settings );
						state.success_url = value;
						this.onChange( state );
					} }
				/>
				<ToggleControl
					label="Use Single sign-on (SSO)"
					help="Allows the existing users to login using their Tokenpass account."
					checked={ this.props.settings.use_single_sign_on }
					onChange={ ( value ) => {
						const state = Object.assign( {}, this.props.settings );
						state.use_single_sign_on = value;
						this.onChange( state );
					} }
				/>
				<ToggleControl
					label="Allow accounts without email"
					help="Allows connecting Tokenpass accounts which have no email accounts associated."
					checked={ this.props.settings.allow_no_email }
					onChange={ ( value ) => {
						const state = Object.assign( {}, this.props.settings );
						state.allow_no_email = value;
						this.onChange( state );
					} }
				/>
				<ToggleControl
					label="Allow accounts without a confirmed email"
					help="Allow connecting Tokenpass accounts which have an unconfirmed email account associated."
					checked={ this.props.settings.allow_unconfirmed_email }
					onChange={ ( value ) => {
						const state = Object.assign( {}, this.props.settings );
						state.allow_unconfirmed_email = value;
						this.onChange( state );
					} }
				/>
			</Flex>
		);
	}
}
 

