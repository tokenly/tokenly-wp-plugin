import Settings from '../Settings';
import OauthSettingsInterface from '../../Interfaces/Models/Settings/OauthSettingsInterface';

export default class OauthSettings extends Settings implements OauthSettingsInterface {
	protected _useSingleSignOn?: boolean = null;
	protected _successUrl?: string = null;
	protected _allowNoEmail?: boolean = null;
	protected _allowUnconfirmedEmail?: boolean = null;

	public get useSingleSignOn(): boolean|null {
		return this._useSingleSignOn ?? null;
	}

	public set useSingleSignOn( value: boolean ) {
		this._useSingleSignOn = value;
	}

	public get successUrl(): string|null {
		return this._successUrl ?? null;
	}

	public set successUrl( value: string ) {
		this._successUrl = value;
	}
	
	public get allowNoEmail(): boolean|null {
		return this._allowNoEmail ?? null;
	}

	public set allowNoEmail( value: boolean ) {
		this._allowNoEmail = value;
	}

	public get allowUnconfirmedEmail(): boolean|null {
		return this._allowUnconfirmedEmail ?? null;
	}

	public set allowUnconfirmedEmail( value: boolean ) {
		this._allowUnconfirmedEmail = value;
	}

	public toJson(): any {
		return {
			...( this.useSingleSignOn ) && { use_single_sign_on: this.useSingleSignOn },
			...( this.successUrl ) && { success_url: this.successUrl },
			...( this.allowNoEmail ) && { allow_no_email: this.allowNoEmail },
			...( this.allowUnconfirmedEmail ) && { allow_unconfirmed_email: this.allowUnconfirmedEmail },
		}
	}

	public fromJson( data: any = {} ): this {
		if ( data.use_single_sign_on ) {
			data.useSingleSignOn = data.use_single_sign_on;
			delete data.use_single_sign_on;
		}
		if ( data.success_url ) {
			data.successUrl = data.success_url;
			delete data.success_url;
		}
		if ( data.allow_no_email ) {
			data.allowNoEmail = data.allow_no_email;
			delete data.allow_no_email;
		}
		if ( data.allow_unconfirmed_email ) {
			data.allowUnconfirmedEmail = data.allow_unconfirmed_email;
			delete data.allow_unconfirmed_email;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'useSingleSignOn',
			'successUrl',
			'allowNoEmail',
			'allowUnconfirmedEmail',
		] );
	}
}