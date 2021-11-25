import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	CheckboxControl,
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
				<div style={{marginBottom: '12px'}}>Enable TCA for the post types:</div>
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
 

