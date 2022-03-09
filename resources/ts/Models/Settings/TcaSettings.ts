import Settings from '../Settings';
import TcaSettingsInterface from '../../Interfaces/Models/Settings/TcaSettingsInterface';

export default class TcaSettings extends Settings implements TcaSettingsInterface {
	protected _taxonomies?: object = null;
	protected _postTypes?: object = null;
	protected _filterMenuItems?: boolean = null;
	protected _filterPostResults?: boolean = null;

	public get taxonomies(): object|null {
		return this._taxonomies ?? null;
	}

	public set taxonomies( value: object ) {
		this._taxonomies = value;
	}

	public get postTypes(): object|null {
		return this._postTypes ?? null;
	}

	public set postTypes( value: object ) {
		this._postTypes = value;
	}

	public get filterMenuItems(): boolean|null {
		return this._filterMenuItems ?? null;
	}

	public set filterMenuItems( value: boolean ) {
		this._filterMenuItems = value;
	}

	public get filterPostResults(): boolean|null {
		return this._filterPostResults ?? null;
	}

	public set filterPostResults( value: boolean ) {
		this._filterPostResults = value;
	}

	public toJson(): any {
		return {
			...( this.taxonomies ) && { taxonomies: this.taxonomies },
			...( this.postTypes ) && { post_types: this.postTypes },
			...( this.filterMenuItems ) && { filter_menu_items: this.filterMenuItems },
			...( this.allowNoEmail ) && { allow_no_email: this.allowNoEmail },
			...( this.filterPostResults ) && { filter_post_results: this.filterPostResults },
		}
	}

	public fromJson( data: any = {} ): this {
		if ( data.post_types ) {
			data.postTypes = data.post_types;
			delete data.post_types;
		}
		if ( data.filter_menu_items ) {
			data.filterMenuItems = data.filter_menu_items;
			delete data.filter_menu_items;
		}
		if ( data.allow_no_email ) {
			data.allowNoEmail = data.allow_no_email;
			delete data.allow_no_email;
		}
		if ( data.filter_post_results ) {
			data.filterPostResults = data.filter_post_results;
			delete data.filter_post_results;
		}
		return super.fromJson( data );
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'taxonomies',
			'postTypes',
			'filterMenuItems',
			'allowNoEmail',
			'filterPostResults',
		] );
	}
}