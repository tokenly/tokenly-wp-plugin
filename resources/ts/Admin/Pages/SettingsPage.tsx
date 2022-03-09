import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import Page from './Page';
import SavePanel from '../Components/SavePanel';
import IntegrationSettingsForm from '../Components/Settings/IntegrationSettingsForm';
import IntegrationSettingsHelp from '../Components/Settings/IntegrationSettingsHelp';
import TcaSettingsForm from '../Components/Settings/TcaSettingsForm';
import OauthSettingsForm from '../Components/Settings/OauthSettingsForm';
import IntegrationSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface';
import TcaSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface';
import OauthSettingsRepositoryInterface from '../../Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface';
import eventBus from "../../EventBus";
import IntegrationSettings from '../../Models/Settings/IntegrationSettings';
import OauthSettings from '../../Models/Settings/OauthSettings';
import TcaSettings from '../../Models/Settings/TcaSettings';
import IntegrationSettingsInterface from '../../Interfaces/Models/Settings/IntegrationSettingsInterface';
import OauthSettingsInterface from '../../Interfaces/Models/Settings/OauthSettingsInterface';
import TcaSettingsInterface from '../../Interfaces/Models/Settings/TcaSettingsInterface';

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SettingsPageProps {
	integration_settings: any;
	integration_data: any;
	tca_settings: any;
	oauth_settings: any;
	tca_data: any;
}

export default function SettingsPage( props: SettingsPageProps ) {
	const brand: string = useInjection( TYPES.Variables.brand );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const integrationSettingsRepository: IntegrationSettingsRepositoryInterface = useInjection( TYPES.Repositories.Settings.IntegrationSettingsRepositoryInterface );
	const tcaSettingsRepository: TcaSettingsRepositoryInterface = useInjection( TYPES.Repositories.Settings.TcaSettingsRepositoryInterface );
	const oauthSettingsRepository: OauthSettingsRepositoryInterface = useInjection( TYPES.Repositories.Settings.OauthSettingsRepositoryInterface );
	
	const [ integrationSettings, setIntegrationSettings ] = useState<IntegrationSettingsInterface>( ( new IntegrationSettings ).fromJson( props.integration_settings ) );
	const [ oauthSettings, setOauthSettings ] = useState<OauthSettingsInterface>( ( new OauthSettings ).fromJson( props.oauth_settings ) );
	const [ tcaSettings, setTcaSettings ] = useState<TcaSettingsInterface>( ( new TcaSettings ).fromJson( props.tca_settings ) );

	const [ savingIntegrationSettings, setSavingIntegrationSettings ] = useState<boolean>( false );
	const [ savingTcaSettings, setSavingTcaSettings ] = useState<boolean>( false );
	const [ savingOauthSettings, setSavingOauthSettings ] = useState<boolean>( false );
	
	function onIntegrationSettingsSave() {
		localStorage.removeItem( `${namespace}-integration-not-connected-notice-dismissed` );
		setSavingIntegrationSettings( true );
		const json = integrationSettings.toJson();
		integrationSettingsRepository.update( json ).then( ( result: any ) => {
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
		const json = tcaSettings.toJson();
		tcaSettingsRepository.update( json ).then( ( result: any ) => {
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
		const json = oauthSettings.toJson();
		oauthSettingsRepository.update( json ).then( ( result: any ) => {
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
