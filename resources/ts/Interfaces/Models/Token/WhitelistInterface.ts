import SettingsInterface from '../SettingsInterface';

export default interface WhitelistInterface extends SettingsInterface {
	enabled?: boolean;
	items?: object;
}