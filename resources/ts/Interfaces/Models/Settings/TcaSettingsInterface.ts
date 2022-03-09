import SettingsInterface from '../SettingsInterface';

export default interface TcaSettingsInterface extends SettingsInterface {
	taxonomies?: any;
	postTypes?: any;
	filterMenuItems?: boolean;
	filterPostResults?: boolean;
}