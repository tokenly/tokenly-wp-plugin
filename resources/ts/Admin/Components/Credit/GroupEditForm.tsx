import * as React from 'react';

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

export default function GroupEditForm( props: GroupEditFormProps ) {

	function onNameFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.name = value;
		props.onChange( state );
	}

	function onWhitelistFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.app_whitelist = value;
		props.onChange( state );
	}

	return (
		<form style={ { maxWidth: "320px" } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<TextControl
					label="Name"
					value={ props.editData.name }
					onChange={ onNameFieldChange }
				/>
				<TextareaControl
					label="App Whitelist"
					help="Comma-separated values."
					value={ props.editData.app_whitelist }
					onChange={ onWhitelistFieldChange }
				/>
			</Flex>
		</form>
	);
}
