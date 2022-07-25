import Settings from '../Settings'
import TcaSettingsInterface
	from '../../Interfaces/Models/Settings/TcaSettingsInterface'

export default class TcaSettings extends Settings
	implements TcaSettingsInterface
{
	public taxonomies?: object = null
	public postTypes?: object = null
	public filterMenuItems?: boolean = null
	public filterPostResults?: boolean = null

	public toJson(): any {
		return {
			...( this.taxonomies ) && { taxonomies: this.taxonomies },
			...( this.postTypes ) && { post_types: this.postTypes },
			...( this.filterMenuItems ) && {
				filter_menu_items: this.filterMenuItems
			},
			...( this.allowNoEmail ) && { allow_no_email: this.allowNoEmail },
			...( this.filterPostResults ) && {
				filter_post_results: this.filterPostResults
			},
		}
	}

	public fromJson( data: any = {} ): this {
		if ( data.post_types ) {
			data.postTypes = data.post_types
			delete data.post_types
		}
		if ( data.filter_menu_items ) {
			data.filterMenuItems = data.filter_menu_items
			delete data.filter_menu_items
		}
		if ( data.allow_no_email ) {
			data.allowNoEmail = data.allow_no_email
			delete data.allow_no_email
		}
		if ( data.filter_post_results ) {
			data.filterPostResults = data.filter_post_results
			delete data.filter_post_results
		}
		return super.fromJson( data )
	}

	protected get fillable(): Array<string> {
		return super.fillable.concat( [
			'taxonomies',
			'postTypes',
			'filterMenuItems',
			'allowNoEmail',
			'filterPostResults',
		] )
	}
}