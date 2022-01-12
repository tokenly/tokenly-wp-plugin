import * as React from 'react';
import { Component } from 'react';

import { 
	TextControl,
	Flex,
	TextareaControl,
} from '@wordpress/components';

interface GroupStoreFormProps {
	onChange: any;
	storeData: any;
}

interface GroupStoreFormState {
	//
}

export default class GroupStoreForm extends Component<GroupStoreFormProps, GroupStoreFormState> {
	state: GroupStoreFormState = {
		//
	};
	
	constructor( props: GroupStoreFormProps ) {
		super( props );
		this.onNameFieldChange = this.onNameFieldChange.bind( this );
		this.onWhitelistFieldChange = this.onWhitelistFieldChange.bind( this );
	}

	onNameFieldChange( value: string ) {
		const state = Object.assign( {}, this.props.storeData );
		state.name = value;
		this.props.onChange( state );
	}

	onWhitelistFieldChange( value: string ) {
		const state = Object.assign( {}, this.props.storeData );
		state.app_whitelist = value;
		this.props.onChange( state );
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<TextControl
						label="Name"
						value={ this.props.storeData?.name }
						onChange={ this.onNameFieldChange }
					/>
					<TextareaControl
						label="App Whitelist"
						value={ this.props.storeData?.app_whitelist }
						help="Comma-separated list."
						onChange={ this.onWhitelistFieldChange }
					/>
				</Flex>
			</form>
		);
	}
}
