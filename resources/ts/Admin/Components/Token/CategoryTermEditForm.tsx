import * as React from 'react';
import MediaPicker from './../MediaPicker';
import MediaRepeater from './../MediaRepeater';
import FormTable from './../FormTable';

import { 
	Flex,
} from '@wordpress/components';

interface CategoryTermEditFormProps {
	editData: any;
	onChange: any;
}

export default function CategoryTermEditForm( props: CategoryTermEditFormProps ) {
	function onFeaturedImageFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.image = value;
		props.onChange( state );
	}

	function onMediaFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData );
		state.media = value;
		props.onChange( state );
	}

	return (
		<form style={ { width: '100%' } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<FormTable
					rows={
						[
							{
								label: 'Featured Image',
								component:
									<MediaPicker
										media={ props.editData?.image }
										onChange={ onFeaturedImageFieldChange }
									/>
							},
							{
								label: 'Media',
								component:
									<MediaRepeater
										label="Media Editor"
										help="Additional media, associated with the category."
										media={ props.editData?.media }
										onChange={ onMediaFieldChange }
									/>
							},
						]
					}
				/>
			</Flex>
		</form>
	);
}
