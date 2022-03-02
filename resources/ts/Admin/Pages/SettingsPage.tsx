import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import Page from './Page';
import SavePanel from '../Components/SavePanel';
import IntegrationSettingsForm from '../Components/Settings/IntegrationSettingsForm';
import IntegrationSettingsHelp from '../Components/Settings/IntegrationSettingsHelp';
import TcaSettingsForm from '../Components/Settings/TcaSettingsForm';
import OauthSettingsForm from '../Components/Settings/OauthSettingsForm';
import { IntegrationSettings, TcaSettings, OauthSettings } from '../../Interfaces';
import IntegrationSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';
import TcaSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';
import OauthSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';
import { TYPES } from '../../Types';
import eventBus from "../../EventBus";

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SettingsPageProps {
	integration_settings: IntegrationSettings;
	integration_data: any;
	tca_settings: TcaSettings;
	oauth_settings: OauthSettings;
	tca_data: any;
}

export default function SettingsPage( props: SettingsPageProps ) {
	const brand: string = useInjection( TYPES.Variables.brand );
	const integrationSettingsRepository: IntegrationSettingsRepositoryInterface = useInjection( TYPES.Repositories.Settings.IntegrationSettingsRepositoryInterface );
	const tcaSettingsRepository: TcaSettingsRepositoryInterface = useInjection( TYPES.Repositories.Settings.TcaSettingsRepositoryInterface );
	const oauthSettingsRepository: OauthSettingsRepositoryInterface = useInjection( TYPES.Repositories.Settings.OauthSettingsRepositoryInterface );
	
	const [ integrationSettings, setIntegrationSettings ] = useState<any>( Object.assign( {
		client_id: '',
		client_secret: '',
	}, props.integration_settings ) );
	const tcaSettingsProp = Object.assign( {
		post_types: {},
		taxonomies: {},
		filter_menu_items: false,
		filter_post_results: false,
	}, props.tca_settings );
	if ( Array.isArray( tcaSettingsProp.post_types ) ) {
		tcaSettingsProp.post_types = {};
	}
	if ( Array.isArray( tcaSettingsProp.taxonomies ) ) {
		tcaSettingsProp.taxonomies = {};
	}
	const [ tcaSettings, setTcaSettings ] = useState<any>( tcaSettingsProp );
	const [ oauthSettings, setOauthSettings ] = useState<any>( Object.assign( {
		use_single_sign_on: false,
		success_url: '',
		allow_no_email: false,
		allow_unconfirmed_email: false,
	}, props.oauth_settings ) );
	const [ savingIntegrationSettings, setSavingIntegrationSettings ] = useState<boolean>( false );
	const [ savingTcaSettings, setSavingTcaSettings ] = useState<boolean>( false );
	const [ savingOauthSettings, setSavingOauthSettings ] = useState<boolean>( false );
	
	function onIntegrationSettingsSave() {
		setSavingIntegrationSettings( true );
		integrationSettingsRepository.update( integrationSettings ).then( ( result: any ) => {
			eventBus.dispatch( 'snackbarShow', result?.status );
			setSavingIntegrationSettings( false );
			window.location.reload();
		} ).catch( ( error: any ) => {
			console.log( error );
		} );
	}

	function onIntegrationSettingsChange( newSettings: any ) {
	setIntegrationSettings( newSettings );
	}

	function onTcaSettingsSave() {
		setSavingTcaSettings( true );
		tcaSettingsRepository.update( tcaSettings ).then( ( result: any ) => {
			eventBus.dispatch( 'snackbarShow', result?.status );
			setSavingTcaSettings( false );
		} ).catch( ( error: any ) => {
			console.log( error );
		} );
	}

	function onTcaSettingsChange( newSettings: any ) {
		setTcaSettings( newSettings );
	}

	function onOauthSettingsSave() {
		setSavingOauthSettings( true );
		oauthSettingsRepository.update( oauthSettings ).then( ( result: any ) => {
			eventBus.dispatch( 'snackbarShow', result?.status );
			setSavingOauthSettings( false );
		} ).catch( ( error: any ) => {
			console.log( error );
		} );
	}

	function onOauthSettingsChange( newSettings: any ) {
		setOauthSettings( newSettings );
	}

	return (
		<Page title={ `${brand} Settings` }>
			<Panel>
				<PanelBody title="Integration">
					<PanelRow>
						<IntegrationSettingsHelp
							appHomepageUrl={ props.integration_data?.app_homepage_url }
							clientAuthUrl={ props.integration_data?.client_auth_url }
						/>
					</PanelRow>
					<PanelRow>
						<IntegrationSettingsForm
							status={ props.integration_data?.status ?? false }
							settings={ integrationSettings }
							onChange={ onIntegrationSettingsChange }
						/>
					</PanelRow>
					<PanelRow>
						<SavePanel
							label="Save Integration Settings"
							saving={ savingIntegrationSettings }
							onClick={ onIntegrationSettingsSave }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelBody title="Token Controlled Access (TCA)">
					<PanelRow>
						<TcaSettingsForm
							settings={ tcaSettings }
							data={ props.tca_data }
							onChange={ onTcaSettingsChange }
						/>
					</PanelRow>
					<PanelRow>
						<SavePanel
							label="Save TCA Settings"
							saving={ savingTcaSettings }
							onClick={ onTcaSettingsSave }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelBody title="Authorization (OAuth)">
					<PanelRow>
						<OauthSettingsForm
							settings={ oauthSettings }
							onChange={ onOauthSettingsChange }
						/>
					</PanelRow>
					<PanelRow>
						<SavePanel
							label="Save OAuth Settings"
							saving={ savingOauthSettings }
							onClick={ onOauthSettingsSave }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
