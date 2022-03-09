import Settings from '../Settings';
import IntegrationSettingsInterface from '../../Interfaces/Models/Settings/IntegrationSettingsInterface';

export default class IntegrationSettings extends Settings implements IntegrationSettingsInterface {
	protected _clientId?: string = null;
	protected _clientSecret?: string = null;
	protected _settingsUpdated?: boolean = null;
	protected _canConnect?: boolean = null;

	public get clientId(): string|null {
		return this._clientId ?? null;
	}

	public set clientId( value: string ) {
		this._clientId = value;
	}

	public get clientSecret(): string|null {
		return this._clientSecret ?? null;
	}

	public set clientSecret( value: string ) {
		this._clientSecret = value;
	}

	public get settingsUpdated(): boolean|null {
		return this._settingsUpdated ?? null;
	}

	public set settingsUpdated( value: boolean ) {
		this._settingsUpdated = value;
	}

	public get canConnect(): boolean|null {
		return this._canConnect ?? null;
	}

	public set canConnect( value: boolean ) {
		this._canConnect = value;
	}

	public fromJson( data: any = {} ): this {
		if ( data.client_id ) {
			data.clientId = data.client_id;
			delete data.client_id;
		}
		if ( data.client_secret ) {
			data.clientSecret = data.client_secret;
			delete data.client_secret;
		}
		if ( data.settings_updated ) {
			data.settingsUpdated = data.settings_updated;
			delete data.settings_updated;
		}
		if ( data.can_connect ) {
			data.settingsUpdated = data.can_connect;
			delete data.can_connect;
		}
		return super.fromJson( data );
	}

	public toJson(): any {
		return {
			...( this.clientId ) && { client_id: this.clientId },
			...( this.clientSecret ) && { client_secret: this.clientSecret },
			...( this.settingsUpdated ) && { settings_updated: this.settingsUpdated },
			...( this.canConnect ) && { can_connect: this.canConnect },
		}
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'clientId',
			'clientSecret',
			'settingsUpdated',
			'canConnect',
		] );
	}
}