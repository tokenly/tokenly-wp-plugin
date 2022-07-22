import SettingsInterface from '../SettingsInterface'

export default interface OauthSettingsInterface extends SettingsInterface {
	useSingleSignOn?: boolean
	successUrl?: string
	allowNoEmail?: boolean
	allowUnconfirmedEmail?: boolean
}