import {
	WhitelistData,
} from './../../Interfaces';

export interface WhitelistRepositoryInterface {
	show(): Promise<any>;
	update( params: WhitelistData ): Promise<any>;
}
