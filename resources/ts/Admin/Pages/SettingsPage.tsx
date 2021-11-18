import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SavePanel } from '../Components/SavePanel';
import { StatusIndicator } from '../Components/StatusIndicator';
import { SettingsData } from '../../Interfaces';
import { SettingsRepositoryInterface } from '../../Interfaces/Repositories/SettingsRepositoryInterface';
import { TYPES } from '../../Types';

import { 
	TextControl,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface SettingsPageData {
	integration_settings: any;
	integration_data: any;
}

interface SettingsPageProps {
	pageData: SettingsPageData; 
}

interface SettingsPageState {
	integrationSettings: SettingsData;
	saving: boolean;
}

export default class SettingsPage extends Component<SettingsPageProps, SettingsPageState> {
	@resolve( TYPES.SettingsRepositoryInterface )
	settingsRepository: SettingsRepositoryInterface;
	
	state: SettingsPageState = {
		integrationSettings: {
			client_id: '',
			client_secret: '',
		},
		saving: false,
	}
	constructor( props: SettingsPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.state.integrationSettings = Object.assign( this.state.integrationSettings, this.props.pageData.integration_settings );
	}
	
	setClientId( value: string ) {
		let state = Object.assign( {}, this.state );
		state.integrationSettings.client_id = value;
		this.setState( state );
	}
	
	setClientSecret( value: string ) {
		let state = Object.assign( {}, this.state );
		state.integrationSettings.client_secret = value;
		this.setState( state );
	}
	
	onSave() {
		this.setState( { saving: true } );
		this.settingsRepository.update( this.state.integrationSettings ).then( result => {
			this.setState( { saving: false } );
			window.location.reload();
		} ).catch( error => {
			console.log( error );
		})
	}

	render() {
		return (
			<Page title={'Tokenpass Settings'}>
				<Panel header="Integration settings">
					<PanelBody>
						<PanelRow>
							<ul className="tk_steps">
								<li>
									<span>1. Add a new application on </span>
									<a href="https://tokenpass.tokenly.com/auth/apps" target="_blank">Tokenpass Developers</a>.
								</li>
								<li>2. Enter the received app credentials below.</li>
								<li>3. Connect your Tokenpass account on the Connection screen to unlock more features.</li>
							</ul>
						</PanelRow>
						<PanelRow>
							<div className="tk_app_details">
								<h3>Register Client Application</h3>
								<span>
									<span><b>CLIENT NAME: </b></span>
									<span>Random Input</span>
								</span>
								<br/>
								<span>
									<span><b>APP HOMEPAGE URL: </b></span>
									<a
										href={ this.props.pageData?.integration_data?.app_homepage_url }
										target="_blank"
									>
										{ this.props.pageData?.integration_data?.app_homepage_url }
									</a>
								</span>
								<br/>
								<span>
									<span><b>CLIENT AUTHORIZATION REDIRECT URL: </b></span>
									<a
										href={ this.props.pageData?.integration_data?.client_auth_url }
										target="_blank"
									>
										{ this.props.pageData?.integration_data?.client_auth_url }
									</a>
								</span>
							</div>
						</PanelRow>
						<PanelRow>
							<Flex
								//@ts-ignore
								direction="column"
								style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
							> 
								<StatusIndicator status={ this.props.pageData?.integration_data?.status ?? false }/>
								<TextControl
									label="Client ID"
									value={ this.state.integrationSettings.client_id ?? '' }
									onChange={ ( value: string ) => {
										this.setClientId( value );
										}
									}
								/>
								<TextControl
									label="Client Secret"
									value={ this.state.integrationSettings.client_secret ?? '' }
									onChange={ ( value: string ) => {
											this.setClientSecret( value );
										}
									}
								/>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<SavePanel saving={ this.state.saving } onClick={ this.onSave } />
			</Page>
		);
	}
}
