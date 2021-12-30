import * as React from 'react';
import { Component } from 'react';
import AttributeRepeater from './../AttributeRepeater';

import { 
	TextControl,
	Flex,
} from '@wordpress/components';

interface MetaEditFormProps {
	editData: any;
	onChange: any;
}

interface MetaEditFormState {
	//
}

export default class MetaEditForm extends Component<MetaEditFormProps, MetaEditFormState> {
	state: MetaEditFormState = {
		//
	};
	constructor( props: MetaEditFormProps ) {
		super( props );
		this.onAssetFieldChange = this.onAssetFieldChange.bind( this );
		this.onExtraFieldChange = this.onExtraFieldChange.bind( this );
	}

	onAssetFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.editData );
		state.asset = value;
		this.props.onChange( state );
	}

	onExtraFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.editData );
		state.extra = value;
		this.props.onChange( state );
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: '500px' } }>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<TextControl
						value={ this.props.editData.asset }
						label="Asset"
						help="Is used for pairing meta with an asset"
						onChange={ this.onAssetFieldChange }
					/>
					<AttributeRepeater
						label="Extra attributes"
						help="Additional key-value asset meta attributes. They are displayed in the more info sections."
						attributes={ this.props.editData.extra }
						onChange={ this.onExtraFieldChange }
					/>
				</Flex>
			</form>
		);
	}
}
