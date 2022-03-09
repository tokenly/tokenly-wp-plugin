import GroupInterface from '../../Models/Credit/GroupInterface';

export default interface GroupRepositoryInterface {
	index( params?: any ): Promise<Array<GroupInterface>>;
	show( uuid: string, params?: any ): Promise<GroupInterface>;
	store( params: any ): Promise<any>;
	update( uuid: string, params: any ): Promise<any>;
	whitelistUpdate( params: any ): Promise<any>;
	accountIndex( uuid: string, params?: any ): Promise<Array<any>>;
}
