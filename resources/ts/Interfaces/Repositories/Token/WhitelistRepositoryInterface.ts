import { TokenWhitelistUpdateParamsInterface } from '../../../Interfaces/Services/ApiServiceInterface';

export default interface WhitelistRepositoryInterface {
	update( params: TokenWhitelistUpdateParamsInterface ): Promise<any>;
}
