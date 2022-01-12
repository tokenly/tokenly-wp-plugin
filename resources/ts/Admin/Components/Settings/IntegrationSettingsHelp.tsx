import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Button,
	Flex,
} from '@wordpress/components';

interface IntegrationSettingsHelpProps {
	appHomepageUrl: string;
	clientAuthUrl: string;
}

interface IntegrationSettingsHelpState {
	copiedHomepage: boolean;
}

export default class IntegrationSettingsHelp extends Component<IntegrationSettingsHelpProps, IntegrationSettingsHelpState> {
	@resolve( TYPES.Variables.brand )
	brand: string;
	@resolve( TYPES.Variables.apiHost )
	apiHost: string;

	state: IntegrationSettingsHelpState = {
		copiedHomepage: false,
	};
	constructor( props: IntegrationSettingsHelpProps ) {
		super( props );
	}

	copyToClipboard( text: string ) {
		if ( navigator && navigator.clipboard ) {
			navigator.clipboard.writeText( text );
		}
	}

	render() {
		return (
			<div>
				<ul className="tk_steps">
					<li>
						<span>1. Add a new application on </span>
						<a href={ `${this.apiHost}/auth/apps` } target="_blank">{ this.brand } Developers</a>.
					</li>
					<li>2. Enter the received app credentials below.</li>
					<li>3. Connect your { this.brand } account on the Connection screen to unlock more features.</li>
				</ul>
				<div className="tk_app_details">
					<h3>Register Client Application</h3>
					<Flex align="center" justify="flex-start" gap={1}>
						<span><b>Client Name: </b></span>
						<span>Random Input</span>
					</Flex>
					<Flex align="center" justify="flex-start" gap={1}>
						<span>
							<span><b>App Homepage URL: </b></span>
							<a href={ this.props?.appHomepageUrl } target="_blank" >
								{ this.props?.appHomepageUrl }
							</a>
						</span>
						<Button
							isSmall
							title="Copy Homepage URL"
							icon="admin-page"
							onClick={ () => {
								this.copyToClipboard( this.props?.appHomepageUrl );
							} }
						/>
					</Flex>
					<Flex align="center" justify="flex-start" gap={ 1 }>
						<span>
							<span><b>Client Authorization Redirect URL: </b></span>
							<a href={ this.props?.clientAuthUrl } target="_blank" >
								{ this.props?.clientAuthUrl }
							</a>
						</span>
						<Button
							isSmall
							title="Copy Redirect URL"
							icon="admin-page"
							onClick={ () => {
								this.copyToClipboard( this.props?.clientAuthUrl );
							} }
						/>
					</Flex>
				</div>
			</div>
		);
	}
}
 

