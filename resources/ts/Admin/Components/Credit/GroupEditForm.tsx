import * as React from 'react';
import { Component } from 'react';

import { 
	TextControl,
	TextareaControl,
	Flex,
} from '@wordpress/components';

interface GroupEditFormProps {
	loadingGroup: boolean;
	editData: any;
	onChange: any;
}

interface GroupEditFormState {
	//
}

export default class GroupEditForm extends Component<GroupEditFormProps, GroupEditFormState> {
	state: GroupEditFormState = {
		//
	};
	constructor( props: GroupEditFormProps ) {
		super( props );
		this.onNameFieldChange = this.onNameFieldChange.bind( this );
		this.onWhitelistFieldChange = this.onWhitelistFieldChange.bind( this );
	}
	
	onNameFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.editData );
		state.name = value;
		this.props.onChange( state );
	}

	onWhitelistFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.editData );
		state.app_whitelist = value;
		this.props.onChange( state );
	}

	render() {
		return (
			<form style={ { maxWidth: "320px" } }>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<TextControl
						label="Name"
						value={ this.props.editData.name }
						onChange={ this.onNameFieldChange }
					/>
					<TextareaControl
						label="App whitelist"
						help="Comma-separated values."
						value={ this.props.editData.app_whitelist }
						onChange={ this.onWhitelistFieldChange }
					/>
				</Flex>
			</form>
		);
	}
}
