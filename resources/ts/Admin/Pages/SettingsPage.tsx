import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';
import { SavePanel } from '../Components/SavePanel';
import { IntegrationSettingsForm } from '../Components/Settings/IntegrationSettingsForm';
import { IntegrationSettingsHelp } from '../Components/Settings/IntegrationSettingsHelp';
import { TcaSettingsForm } from '../Components/Settings/TcaSettingsForm';
import { OauthSettingsForm } from '../Components/Settings/OauthSettingsForm';
import { IntegrationSettings, TcaSettings, OauthSettings } from '../../Interfaces';
import { IntegrationSettingsRepositoryInterface } from '../../Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';
import { TcaSettingsRepositoryInterface } from '../../Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';
import { OauthSettingsRepositoryInterface } from '../../Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';
import { TYPES } from '../../Types';

import { 
	TextControl,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface SettingsPageData {
	integration_settings: IntegrationSettings;
	integration_data: any;
	tca_settings: TcaSettings;
	oauth_settings: OauthSettings;
	tca_data: any;
}

interface SettingsPageProps {
	pageData: SettingsPageData; 
}

interface SettingsPageState {
	integrationSettings: IntegrationSettings;
	tcaSettings: TcaSettings;
	oauthSettings: OauthSettings;
	savingIntegrationSettings: boolean;
	savingTcaSettings: boolean;
	savingOauthSettings: boolean;
}

export default class SettingsPage extends Component<SettingsPageProps, SettingsPageState> {
	@resolve( TYPES.IntegrationSettingsRepositoryInterface )
	integrationSettingsRepository: IntegrationSettingsRepositoryInterface;
	@resolve( TYPES.TcaSettingsRepositoryInterface )
	tcaSettingsRepository: TcaSettingsRepositoryInterface;
	@resolve( TYPES.OauthSettingsRepositoryInterface )
	oauthSettingsRepository: OauthSettingsRepositoryInterface;
	
	state: SettingsPageState = {
		integrationSettings: {
			client_id: '',
			client_secret: '',
		},
		tcaSettings: {
			post_types: {},
			filter_menu_items: null,
			filter_post_results: null,
		},
		oauthSettings: {
			use_single_sign_on: null,
			success_url: '',
			allow_no_email: null,
			allow_unconfirmed_email: null,
		},
		savingIntegrationSettings: false,
		savingTcaSettings: false,
		savingOauthSettings: false,
	}
	constructor( props: SettingsPageProps ) {
		super( props );
		this.onIntegrationSettingsSave = this.onIntegrationSettingsSave.bind( this );
		this.onIntegrationSettingsChange = this.onIntegrationSettingsChange.bind( this );
		this.onTcaSettingsSave = this.onTcaSettingsSave.bind( this );
		this.onTcaSettingsChange = this.onTcaSettingsChange.bind( this );
		this.onOauthSettingsSave = this.onOauthSettingsSave.bind( this );
		this.onOauthSettingsChange = this.onOauthSettingsChange.bind( this );
		this.state.integrationSettings = Object.assign( this.state.integrationSettings, this.props.pageData.integration_settings );
		this.state.tcaSettings = Object.assign( {}, this.props.pageData?.tca_settings );
		if ( !this.state.tcaSettings.post_types ) {
			this.state.tcaSettings.post_types = {};
		}
		this.state.oauthSettings = Object.assign( this.state.oauthSettings, this.props.pageData.oauth_settings );
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
		this.integrationSettingsRepository.update( this.state.integrationSettings ).then( ( result: any ) => {
			this.setState( { savingIntegrationSettings: false } );
			window.location.reload();
		} ).catch( ( error: any ) => {
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

	onOauthSettingsSave() {
		this.setState( { savingOauthSettings: true } );
		this.oauthSettingsRepository.update( this.state.oauthSettings ).then( ( result: any ) => {
			this.setState( { savingOauthSettings: false } );
		} ).catch( ( error: any ) => {
			console.log( error );
		})
	}

	onOauthSettingsChange( newSettings: any ) {
		this.setState( { oauthSettings: newSettings } )
	}

	render() {
		return (
			<Page title={'Tokenpass Settings'}>
				<Panel>
					<PanelBody title="Integration">
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
					<PanelBody title="Token Controlled Access (TCA)">
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
				<Panel>
					<PanelBody title="Authorization (OAuth)">
						<PanelRow>
							<OauthSettingsForm
								settings={ this.state.oauthSettings }
								onChange={ this.onOauthSettingsChange }
							/>
						</PanelRow>
						<PanelRow>
							<SavePanel
								label="Save OAuth settings"
								saving={ this.state.savingOauthSettings }
								onClick={ this.onOauthSettingsSave }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
