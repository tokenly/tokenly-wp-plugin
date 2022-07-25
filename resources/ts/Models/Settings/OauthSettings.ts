import Settings from '../Settings'
import OauthSettingsInterface
	from '../../Interfaces/Models/Settings/OauthSettingsInterface'

export default class OauthSettings extends Settings
	implements OauthSettingsInterface
{
	public useSingleSignOn?: boolean = null
	public successUrl?: string = null
	public allowNoEmail?: boolean = null
	public allowUnconfirmedEmail?: boolean = null

	public toJson(): any {
		return {
			...( this.useSingleSignOn ) && {
					use_single_sign_on: this.useSingleSignOn
			},
			...( this.successUrl ) && { success_url: this.successUrl },
			...( this.allowNoEmail ) && { allow_no_email: this.allowNoEmail },
			...( this.allowUnconfirmedEmail ) && {
					allow_unconfirmed_email: this.allowUnconfirmedEmail
			},
		}
	}

	public fromJson( data: any = {} ): this {
		if ( data.use_single_sign_on ) {
			data.useSingleSignOn = data.use_single_sign_on
			delete data.use_single_sign_on
		}
		if ( data.success_url ) {
			data.successUrl = data.success_url
			delete data.success_url
		}
		if ( data.allow_no_email ) {
			data.allowNoEmail = data.allow_no_email
			delete data.allow_no_email
		}
		if ( data.allow_unconfirmed_email ) {
			data.allowUnconfirmedEmail = data.allow_unconfirmed_email
			delete data.allow_unconfirmed_email
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'useSingleSignOn',
			'successUrl',
			'allowNoEmail',
			'allowUnconfirmedEmail',
		] )
	}
}