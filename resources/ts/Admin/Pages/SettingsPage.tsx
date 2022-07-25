import * as React from 'react'
import { useState } from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'
import Page from './Page'
import SavePanel from '../Components/SavePanel'
import IntegrationSettingsForm
	from '../Components/Settings/IntegrationSettingsForm'
import IntegrationSettingsHelp
	from '../Components/Settings/IntegrationSettingsHelp'
import TcaSettingsForm from '../Components/Settings/TcaSettingsForm'
import OauthSettingsForm from '../Components/Settings/OauthSettingsForm'
import IntegrationSettingsRepositoryInterface
	from '../../Interfaces/Repositories/Settings/IntegrationSettingsRepositoryInterface'
import TcaSettingsRepositoryInterface
	from '../../Interfaces/Repositories/Settings/TcaSettingsRepositoryInterface'
import OauthSettingsRepositoryInterface
	from '../../Interfaces/Repositories/Settings/OauthSettingsRepositoryInterface'
import eventBus from "../../EventBus"
import IntegrationSettings from '../../Models/Settings/IntegrationSettings'
import OauthSettings from '../../Models/Settings/OauthSettings'
import TcaSettings from '../../Models/Settings/TcaSettings'
import IntegrationSettingsInterface
	from '../../Interfaces/Models/Settings/IntegrationSettingsInterface'
import OauthSettingsInterface
	from '../../Interfaces/Models/Settings/OauthSettingsInterface'
import TcaSettingsInterface
	from '../../Interfaces/Models/Settings/TcaSettingsInterface'
import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components'

interface SettingsPageProps {
	integration_settings: {
		can_connect: true
		client_id: string
		client_secret: string
		extra_scopes: Array<string>
		settings_updated: boolean
	}
	integration_data: {
		app_homepage_url: string
		client_auth_url: string
		status: boolean
	}
	tca_settings: {
		filter_menu_items: boolean
		filter_post_results: boolean
	}
	oauth_settings: {
		allow_no_email: boolean
		allow_unconfirmed_email: boolean
		success_url: string,
		use_single_sign_on: boolean
	}
	tca_data: {
		post_types: object
		taxonomies: object
	}
}

export default function SettingsPage( props: SettingsPageProps ) {
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const integrationSettingsRepository: IntegrationSettingsRepositoryInterface =
		useInjection(
			TYPES.Repositories.Settings.IntegrationSettingsRepositoryInterface
		)
	const tcaSettingsRepository: TcaSettingsRepositoryInterface =
		useInjection(
			TYPES.Repositories.Settings.TcaSettingsRepositoryInterface
		)
	const oauthSettingsRepository: OauthSettingsRepositoryInterface =
		useInjection(
			TYPES.Repositories.Settings.OauthSettingsRepositoryInterface
		)
	const dictionary: any = useInjection( TYPES.Variables.dictionary )
	const [ integrationSettings, setIntegrationSettings ] = 
		useState<IntegrationSettingsInterface>(
			( new IntegrationSettings ).fromJson(
				Object.assign( {}, props.integration_settings ) )
		)
	const [ oauthSettings, setOauthSettings ] =
		useState<OauthSettingsInterface>(
			( new OauthSettings ).fromJson(
				Object.assign( {}, props.oauth_settings )
			)
		)
	const [ tcaSettings, setTcaSettings ] = useState<TcaSettingsInterface>(
		( new TcaSettings ).fromJson(
			Object.assign( {}, props.tca_settings )
		)
	)
	const [ savingIntegrationSettings, setSavingIntegrationSettings ] =
		useState<boolean>( false )
	const [ savingTcaSettings, setSavingTcaSettings ] =
		useState<boolean>( false )
	const [ savingOauthSettings, setSavingOauthSettings ] =
		useState<boolean>( false )
	
	function onIntegrationSettingsSave() {
		const storageKey = 
			`${namespace}-integration-not-connected-notice-dismissed`
		localStorage.removeItem( storageKey )
		setSavingIntegrationSettings( true )
		const json = integrationSettings.toJson()
		integrationSettingsRepository.update( json ).then( ( result: any ) => {
			eventBus.dispatch( 'snackbarShow', result?.status )
			setSavingIntegrationSettings( false )
			window.location.reload()
		} ).catch( ( error: any ) => {
			console.log( error )
		} )
	}

	function onIntegrationSettingsChange( newSettings: any ) {
		setIntegrationSettings( newSettings )
	}

	function onTcaSettingsSave() {
		setSavingTcaSettings( true )
		const json = tcaSettings.toJson()
		tcaSettingsRepository.update( json ).then( ( result: any ) => {
			eventBus.dispatch( 'snackbarShow', result?.status )
			setSavingTcaSettings( false )
		} ).catch( ( error: any ) => {
			console.log( error )
		} )
	}

	function onTcaSettingsChange( newSettings: any ) {
		setTcaSettings( newSettings )
	}

	function onOauthSettingsSave() {
		setSavingOauthSettings( true )
		const json = oauthSettings.toJson()
		oauthSettingsRepository.update( json ).then( ( result: any ) => {
			eventBus.dispatch( 'snackbarShow', result?.status )
			setSavingOauthSettings( false )
		} ).catch( ( error: any ) => {
			console.log( error )
		} )
	}

	function onOauthSettingsChange( newSettings: any ) {
		setOauthSettings( newSettings )
	}

	return (
		<Page title={ dictionary.get( 'settingsTitle' ) }>
			<Panel>
				<PanelBody 
					title={ dictionary.get( 'settingsIntegrationTitle' ) }
				>
					<PanelRow>
						<IntegrationSettingsHelp
							appHomepageUrl={
								props.integration_data?.app_homepage_url
							}
							clientAuthUrl={
								props.integration_data?.client_auth_url
							}
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
							label={
								dictionary.get( 'settingsIntegrationSave' )
							}
							saving={ savingIntegrationSettings }
							onClick={ onIntegrationSettingsSave }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelBody title={ dictionary.get( 'settingsTcaTitle' ) }>
					<PanelRow>
						<TcaSettingsForm
							settings={ tcaSettings }
							data={ props.tca_data }
							onChange={ onTcaSettingsChange }
						/>
					</PanelRow>
					<PanelRow>
						<SavePanel
							label={ dictionary.get( 'settingsTcaSave' ) }
							saving={ savingTcaSettings }
							onClick={ onTcaSettingsSave }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelBody title={ dictionary.get( 'settingsOauthTitle' ) }>
					<PanelRow>
						<OauthSettingsForm
							settings={ oauthSettings }
							onChange={ onOauthSettingsChange }
						/>
					</PanelRow>
					<PanelRow>
						<SavePanel
							label={ dictionary.get( 'settingsOauthSave' ) }
							saving={ savingOauthSettings }
							onClick={ onOauthSettingsSave }
						/>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	)
}
