import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SavePanel } from '../Components/SavePanel';
import { IntegrationSettingsForm } from '../Components/IntegrationSettingsForm';
import { IntegrationSettingsHelp } from '../Components/IntegrationSettingsHelp';
import { TcaSettingsForm } from '../Components/TcaSettingsForm';
import { SettingsData } from '../../Interfaces';
import { IntegrationSettingsRepositoryInterface } from '../../Interfaces/Repositories/IntegrationSettingsRepositoryInterface';
import { TcaSettingsRepositoryInterface } from '../../Interfaces/Repositories/TcaSettingsRepositoryInterface';
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
	tca_settings: any;
	tca_data: any;
}

interface SettingsPageProps {
	pageData: SettingsPageData; 
}

interface SettingsPageState {
	integrationSettings: SettingsData;
	tcaSettings: any;
	savingIntegrationSettings: boolean,
	savingTcaSettings: boolean,
}

export default class SettingsPage extends Component<SettingsPageProps, SettingsPageState> {
	@resolve( TYPES.IntegrationSettingsRepositoryInterface )
	integrationSettingsRepository: IntegrationSettingsRepositoryInterface;
	@resolve( TYPES.TcaSettingsRepositoryInterface )
	tcaSettingsRepository: TcaSettingsRepositoryInterface;
	
	state: SettingsPageState = {
		integrationSettings: {
			client_id: '',
			client_secret: '',
		},
		tcaSettings: {
			post_types: {},
			filter_menu_items: false,
			filter_post_results: false,
		},
		savingIntegrationSettings: false,
		savingTcaSettings: false,
	}
	constructor( props: SettingsPageProps ) {
		super( props );
		this.onIntegrationSettingsSave = this.onIntegrationSettingsSave.bind( this );
		this.onIntegrationSettingsChange = this.onIntegrationSettingsChange.bind( this );
		this.onTcaSettingsSave = this.onTcaSettingsSave.bind( this );
		this.onTcaSettingsChange = this.onTcaSettingsChange.bind( this );
		this.state.integrationSettings = Object.assign( this.state.integrationSettings, this.props.pageData.integration_settings );
		this.state.tcaSettings = Object.assign( {}, this.props.pageData?.tca_settings );
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
		this.setState( { savingIntegrationSettings: true } );
		this.integrationSettingsRepository.update( this.state.integrationSettings ).then( result => {
			this.setState( { savingIntegrationSettings: false } );
			window.location.reload();
		} ).catch( error => {
			console.log( error );
		})
	}

	onIntegrationSettingsChange( newSettings: any ) {
		this.setState( { integrationSettings: newSettings } );
	}

	onTcaSettingsSave() {
		this.setState( { savingTcaSettings: true } );
		this.tcaSettingsRepository.update( this.state.tcaSettings ).then( ( result: any ) => {
			this.setState( { savingTcaSettings: false } );
		} ).catch( ( error: any ) => {
			console.log( error );
		})
	}

	onTcaSettingsChange( newSettings: any ) {
		this.setState( { tcaSettings: newSettings } )
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
								saving={ this.state.savingIntegrationSettings }
								onClick={ this.onIntegrationSettingsSave }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody title="TCA settings">
						<PanelRow>
							<TcaSettingsForm
								settings={ this.state.tcaSettings }
								data={ this.props.pageData.tca_data }
								onChange={ this.onTcaSettingsChange }
							/>
						</PanelRow>
						<PanelRow>
							<SavePanel
								label="Save TCA settings"
								saving={ this.state.savingTcaSettings }
								onClick={ this.onTcaSettingsSave }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
