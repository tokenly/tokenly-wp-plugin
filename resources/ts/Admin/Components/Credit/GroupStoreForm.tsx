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

export default function GroupStoreForm( props: GroupStoreFormProps ) {
	function onNameFieldChange( value: string ) {
		const state = Object.assign( {}, props.storeData );
		state.name = value;
		props.onChange( state );
	}

	function onWhitelistFieldChange( value: string ) {
		const state = Object.assign( {}, props.storeData );
		state.app_whitelist = value;
		props.onChange( state );
	}

	return (
		<div style={ { width: '100%', maxWidth: "400px" } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<TextControl
					label="Name"
					value={ props.storeData?.name }
					onChange={ onNameFieldChange }
					required
				/>
				<TextareaControl
					label="App Whitelist"
					value={ props.storeData?.app_whitelist }
					help="Comma-separated list."
					onChange={ onWhitelistFieldChange }
				/>
			</Flex>
		</div>
	);
}
