import ModelInterface from './ModelInterface';

import OauthUserInterface from './OauthUserInterface';

export default interface UserInterface extends ModelInterface {
	id?: number;
	name?: string;
	nameDisplay?: string;
	description?: string;
	avatar?: string;
	canConnect?: boolean;
	oauthUser?: OauthUserInterface;
}