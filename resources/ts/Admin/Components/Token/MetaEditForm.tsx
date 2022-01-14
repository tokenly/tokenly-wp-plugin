import * as React from 'react';
import AttributeRepeater from './../AttributeRepeater';

import { 
	TextControl,
	Flex,
} from '@wordpress/components';

interface MetaEditFormProps {
	editData: any;
	onChange: any;
}

export default function MetaEditForm( props: MetaEditFormProps ) {
	function onAssetFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.asset = value;
		props.onChange( state );
	}

	function onExtraFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.extra = value;
		props.onChange( state );
	}

	return (
		<form style={ { width: '100%', maxWidth: '500px' } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<TextControl
					value={ props.editData.asset }
					label="Asset"
					help="Is used for pairing meta with an asset"
					onChange={ onAssetFieldChange }
				/>
				<AttributeRepeater
					label="Extra Attributes"
					help="Additional key-value asset meta attributes. They are displayed in the more info sections."
					attributes={ props.editData.extra }
					onChange={ onExtraFieldChange }
				/>
			</Flex>
		</form>
	);
}
