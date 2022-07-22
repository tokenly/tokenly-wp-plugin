import Model from './Model'
import UserInterface from '../Interfaces/Models/UserInterface'
import OauthUserInterface from '../Interfaces/Models/OauthUserInterface'

export default class User extends Model implements UserInterface {
	public id?: number
	public name?: string
	public nameDisplay?: string
	public description?: string
	public avatar?: string
	public canConnect?: boolean
	public oauthUser?: OauthUserInterface

	public fromJson( data: any = {} ): this {
		if ( data.name_display ) {
			data.nameDisplay = data.name_display
			delete data.name_display
		}
		if ( data.can_connect ) {
			data.canConnect = data.can_connect
			delete data.can_connect
		}
		if ( data.oauth_user ) {
			data.oauthUser = data.oauth_user
			delete data.oauth_user
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'id',
			'name',
			'nameDisplay',
			'avatar',
			'canConnect',
			'oauthUser',
		] )
	}
}