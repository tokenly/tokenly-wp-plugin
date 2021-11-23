import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SavePanel } from '../Components/SavePanel';
import { IntegrationSettingsForm } from '../Components/IntegrationSettingsForm';
import { IntegrationSettingsHelp } from '../Components/IntegrationSettingsHelp';
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
		this.onIntegrationSettingsSave = this.onIntegrationSettingsSave.bind( this );
		this.onIntegrationSettingsChange = this.onIntegrationSettingsChange.bind( this );
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
	
	onIntegrationSettingsSave() {
		this.setState( { saving: true } );
		this.settingsRepository.update( this.state.integrationSettings ).then( result => {
			this.setState( { saving: false } );
			window.location.reload();
		} ).catch( error => {
			console.log( error );
		})
	}

	onIntegrationSettingsChange( newSettings: any ) {
		this.setState( { integrationSettings: newSettings } );
	}

	render() {
		return (
			<Page title={'Tokenpass Settings'}>
				<Panel>
					<PanelBody title="Integration settings">
						<PanelRow>
							<IntegrationSettingsHelp
								appHomepageUrl={ this.props.pageData?.integration_data?.app_homepage_url }
								clientAuthUrl={ this.props.pageData?.integration_data?.client_auth_url }
							/>
						</PanelRow>
						<PanelRow>
							<IntegrationSettingsForm
								status={ this.props.pageData?.integration_data?.status ?? false }
								settings={ this.state.integrationSettings }
								onChange={ this.onIntegrationSettingsChange }
							/>
						</PanelRow>
						<PanelRow>
							<SavePanel
								label="Save Integration settings"
								saving={ this.state.saving }
								onClick={ this.onIntegrationSettingsSave }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody title="TCA settings">
						<PanelRow>
							<SavePanel
								label="Save TCA settings"
								saving={ this.state.saving }
								onClick={ this.onIntegrationSettingsSave }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
