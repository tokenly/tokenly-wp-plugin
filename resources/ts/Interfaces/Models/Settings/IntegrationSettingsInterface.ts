import SettingsInterface from '../SettingsInterface'

export default interface IntegrationSettingsInterface extends SettingsInterface {
	clientId?: string
	clientSecret?: string
	settingsUpdated?: boolean
	canConnect?: boolean
}