import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	CheckboxControl,
	ToggleControl,
} from '@wordpress/components';

interface TcaSettingsFormProps {
	settings: any;
	data: any;
	onChange: any;
}

interface TcaSettingsFormState {
	//
}

export default class TcaSettingsForm extends Component<TcaSettingsFormProps, TcaSettingsFormState> {

	constructor( props: TcaSettingsFormProps ) {
		super( props );
		this.onChange = this.onChange.bind( this );
		this.isPostTypeChecked = this.isPostTypeChecked.bind( this );
		this.isTaxonomyChecked = this.isTaxonomyChecked.bind( this );
		this.onFilterMenuItemsFieldChange = this.onFilterMenuItemsFieldChange.bind( this );
		this.onFilterPostResultsFieldChange = this.onFilterPostResultsFieldChange.bind( this );
	}

	onChange( newSettings: any ) {
		this.props.onChange( newSettings );
	}

	isPostTypeChecked( key: string ) {
		let checked = false;
		if ( this.props.settings?.post_types && this.props.settings?.post_types[ key ] ) {
			checked = this.props.settings.post_types[ key ]
		}
		return checked;
	}

	isTaxonomyChecked( key: string ) {
		let checked = false;
		if ( this.props.settings?.taxonomies && this.props.settings?.taxonomies[ key ] ) {
			checked = this.props.settings.taxonomies[ key ]
		}
		return checked;
	}

	onFilterMenuItemsFieldChange( value: any ) {
		let settings = Object.assign( {}, this.props.settings );
		settings.filter_menu_items = value;
		this.onChange( settings );
	}
 
	onFilterPostResultsFieldChange( value: any ) {
		let settings = Object.assign( {}, this.props.settings );
		settings.filter_post_results = value;
		this.onChange( settings );
	}

	render() {
		const postTypes: any = [];
		if ( this.props.data.post_types ) {
			Object.keys( this.props.data.post_types ).map( ( key: string, index: number ) => {
				const label = this.props.data.post_types[ key ];
				const item = (
					<CheckboxControl
						label={ label }
						checked={ this.isPostTypeChecked( key ) }
						onChange={ ( value: any ) => {
							let settings = Object.assign( {}, this.props.settings );
							settings.post_types[ key ] = value;
							this.onChange( settings );
						} }
					/>
				);
				postTypes.push( item );
			});
		}
		const taxonomies: any = [];
		if ( this.props.data.taxonomies ) {
			Object.keys( this.props.data.taxonomies ).map( ( key: string, index: number ) => {
				const label = this.props.data.taxonomies[ key ];
				const item = (
					<CheckboxControl
						label={ label }
						checked={ this.isTaxonomyChecked( key ) }
						onChange={ ( value: any ) => {
							let settings = Object.assign( {}, this.props.settings );
							settings.taxonomies[ key ] = value;
							this.onChange( settings );
						} }
					/>
				);
				taxonomies.push( item );
			});
		}
		return (
			<Flex
				//@ts-ignore
				direction="column"
			>
				<fieldset>
					<Flex
						//@ts-ignore
						direction="column"
					>	
						<legend style={ { marginBottom: '8px' } }>
							<b>Filtering Options</b>
							<div>Filtering the content can slow down page loading speed. <br />
								The following options allow fine-grained control over what gets filtered.</div>
						</legend>
						<ToggleControl
							label="Filter Menu Items"
							help="Filters the menus made via Customizer. Note that the custom / external links will not be tested."
							checked={ this.props.settings.filter_menu_items }
							onChange={ this.onFilterMenuItemsFieldChange }
						/>
						<ToggleControl
							label="Filter Post Results"
							help="Filters the post listings which are not controlable by the menu editor, like recent post list."
							checked={ this.props.settings.filter_post_results }
							onChange={ this.onFilterPostResultsFieldChange }
						/>
					</Flex>
				</fieldset>
				<hr />
				<div>
					<b>Post Types</b>
					<div>The selected post types will be able to use the TCA functions. <br/> The rule editor will be available at the post editing screen.</div>
				</div>
				<Flex
					//@ts-ignore
					direction="column"
					style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
				>
					{ postTypes.length > 0 ? postTypes : <div style={{opacity: 0.6}}>No post types found</div>}
				</Flex>
				<div style={{marginTop: '12px'}}>
					<b>Taxonomies</b>
					<div>The selected taxonomies will be able to use the TCA functions. <br/> The rule editor will be available at the taxonomy term editing screen.</div>
				</div>
				<Flex
					//@ts-ignore
					direction="column"
					style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
				>
					{ taxonomies.length > 0 ? taxonomies : <div style={{opacity: 0.6}}>No taxonomies found</div>}
				</Flex>
			</Flex>
		);
	}
}
 

