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

export class TcaSettingsForm extends Component<TcaSettingsFormProps, TcaSettingsFormState> {

	constructor( props: TcaSettingsFormProps ) {
		super( props );
		this.onChange = this.onChange.bind( this );
		this.isPostTypeChecked = this.isPostTypeChecked.bind( this );
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

	render() {
		let listItems: any = [];
		Object.keys( this.props.data.post_types ).map( ( key: string, index: number ) => {
			const label = this.props.data.post_types[ key ];
			const item = (
				<CheckboxControl
					label={ label }
					checked={ this.isPostTypeChecked( key ) }
					onChange={ ( value: any ) => {
						let settings = Object.assign( {}, this.props.settings );
						if ( settings.post_types && typeof settings.post_types == 'object' ) {
							settings.post_types[ key ] = value;
						}
						this.onChange( settings );
					} }
				/>
			);
			listItems.push( item );
		});
		return (
			<div>
				<fieldset>
					<Flex
						//@ts-ignore
						direction="column"
					>	
						<legend style={ { marginBottom: '8px' } }>
							<strong>Filtering options</strong>
							<div>Filtering the content can slow down page loading speed. <br />
								The following options allow fine-grained control over what gets filtered.</div>
						</legend>
						<ToggleControl
							label="Filter menu items"
							help="Filters the menus made via Customizer. Note that the custom / external links will not be tested."
							checked={ this.props.settings.filter_menu_items }
							onChange={ ( value: boolean ) => {
								let settings = Object.assign( {}, this.props.settings );
								settings.filter_menu_items = value;
								this.onChange( settings );
							} }
						/>
						<ToggleControl
							label="Filter post results"
							help="Filters the post listings which are not controlable by the menu editor, like recent post list."
							checked={ this.props.settings.filter_post_results }
							onChange={ ( value: boolean ) => {
								let settings = Object.assign( {}, this.props.settings );
								settings.filter_post_results = value;
								this.onChange( settings );
							} }
						/>
					</Flex>
				</fieldset>
				<hr></hr>
				<div>
					<strong>TCA post types</strong>
					<div>The selected post types will be able to use the TCA functions.</div>
				</div>
				<Flex
					//@ts-ignore
					direction="column"
					style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
				>
					{ listItems }
				</Flex>
			</div>
		);
	}
}
 

