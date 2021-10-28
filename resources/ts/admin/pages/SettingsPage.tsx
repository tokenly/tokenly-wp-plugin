import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SavePanel } from '../components/SavePanel';
import { SettingsRepository, SettingsData } from '../../repositories/SettingsRepository';

import { 
	TextControl,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SettingsPageData {
	app_homepage_url: string;
	client_auth_url: string;
}

interface SettingsPageProps {
	pageData: SettingsPageData; 
}

interface SettingsPageState {
	settingsData: SettingsData;
	saving: boolean;
}

export default class SettingsPage extends Component<SettingsPageProps, SettingsPageState> {
	@resolve
	settingsRepository: SettingsRepository;
	
	state: SettingsPageState = {
		settingsData: {
			client_id: '',
			client_secret: '',
		},
		saving: false,
	}
	constructor( props: SettingsPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
	}
	
	setClientId( value: string ) {
		let state = Object.assign( {}, this.state );
		state.settingsData.client_id = value;
		this.setState( state );
	}
	
	setClientSecret( value: string ) {
		let state = Object.assign( {}, this.state );
		state.settingsData.client_secret = value;
		this.setState( state );
	}
	
	componentDidMount() {
		this.settingsRepository.read().then( ( settingsData: SettingsData ) => {
			this.setState( {
				settingsData: settingsData,
			} );
		} );
	}
	
	onSave() {
		this.setState( { saving: true } );
		this.settingsRepository.update( this.state.settingsData ).then( result => {
			this.setState( { saving: false } );
		} ).catch( error => {
			console.log( error );
		})
	}

	render() {
		return (
			<Page title={'Tokenpass Settings'}>
				<Panel header="How to Setup">
					<PanelBody>
						<PanelRow>
							<ul className="tk_steps">
								<li>1. Create App on <a href="https://tokenpass.tokenly.com/auth/apps" target="_blank">Tokenpass Developers</a></li>
								<li>2. Use below details to create App</li>
							</ul>
						</PanelRow>
						<PanelRow>
							<div className="tk_app_details">
								<h3>Register Client Application</h3>
								<span> <b>CLIENT NAME: </b> Random Input </span><br/>
								<span> <b>APP HOMEPAGE URL: </b> <a href={this.props.pageData.app_homepage_url} target="_blank">{this.props.pageData.app_homepage_url}</a> </span><br/>
								<span> <b>CLIENT AUTHORIZATION REDIRECT URL: </b> <a href={this.props.pageData.client_auth_url} target="_blank">{this.props.pageData.client_auth_url}</a> </span>
							</div>
						</PanelRow>
						<PanelRow className="api-input-container">
							<TextControl
								label="Client ID"
								value={ this.state.settingsData.client_id }
								onChange={ ( value: string ) => {
									this.setClientId( value );
									}
								}
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Client Secret"
								value={ this.state.settingsData.client_secret }
								onChange={ ( value: string ) => {
										this.setClientSecret( value );
									}
								}
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<SavePanel saving={ this.state.saving } onClick={ this.onSave } />
			</Page>
		);
	}
}
