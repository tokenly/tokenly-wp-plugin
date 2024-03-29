import Settings from '../Settings'
import IntegrationSettingsInterface
	from '../../Interfaces/Models/Settings/IntegrationSettingsInterface'

export default class IntegrationSettings extends Settings
	implements IntegrationSettingsInterface
{
	public clientId?: string = null
	public clientSecret?: string = null
	public extraScopes?: Array<string> = null
	public settingsUpdated?: boolean = null
	public canConnect?: boolean = null

	public fromJson( data: any = {} ): this {
		if ( data.client_id ) {
			data.clientId = data.client_id
			delete data.client_id
		}
		if ( data.client_secret ) {
			data.clientSecret = data.client_secret
			delete data.client_secret
		}
		if ( data.settings_updated ) {
			data.settingsUpdated = data.settings_updated
			delete data.settings_updated
		}
		if ( data.can_connect ) {
			data.settingsUpdated = data.can_connect
			delete data.can_connect
		}
		if ( data.extra_scopes ) {
			data.extraScopes = data.extra_scopes
			delete data.extra_scopes
		}
		return super.fromJson( data )
	}

	public toJson(): any {
		return {
			...( this.clientId || this.clientId == '' ) && {
				client_id: this.clientId
			},
			...( this.clientSecret || this.clientSecret == '' ) && {
				client_secret: this.clientSecret
			},
			...( this.settingsUpdated ) && {
				settings_updated: this.settingsUpdated
			},
			...( this.canConnect ) && { can_connect: this.canConnect },
			...( this.extraScopes ) && { extra_scopes: this.extraScopes },
		}
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'clientId',
			'clientSecret',
			'settingsUpdated',
			'canConnect',
			'extraScopes',
		] )
	}
}