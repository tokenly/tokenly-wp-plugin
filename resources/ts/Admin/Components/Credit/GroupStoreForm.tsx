import * as React from 'react';
import { useForm } from "react-hook-form";

import { 
	TextControl,
	Flex,
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

	return (
		<div style={ { width: '100%', maxWidth: "400px" } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<TextControl
					label="Name *"
					value={ props.storeData?.name }
					onChange={ onNameFieldChange }
					required
				/>
			</Flex>
		</div>
	);
}
