import * as React from 'react';
import { useState, useEffect } from 'react';
import RuleEditor from '../Components/Token/Access/RuleEditor';

import { 
	Flex,
} from '@wordpress/components';

export interface PostEditPageProps {
	tca_rules: any;
	tca_enabled: boolean;
	children: any;
	onPostDataChange: any;
}

export default function PostEditPage( props: PostEditPageProps ) {
	const [ editData, setEditData ] = useState<any>( {
		tca_rules: props.tca_rules,
	} );

	function onEditDataChange( newData: any ) {
		setEditData( newData );
		props.onPostDataChange( newData );
	}

	function onRulesFieldChange( newRules: any ) {
		let state = Object.assign( {}, editData );
		state.tca_rules = newRules;
		onEditDataChange( state );
	}

	useEffect( () => {
		props.onPostDataChange( editData );
	}, [] );

	return (
		<Flex
			//@ts-ignore
			direction="column"
			gap={ 4 }
			style={{maxWidth: '500px'}}
		>
			<Flex
				//@ts-ignore
				direction="column"
				gap={ 4 }
			>
				{ props.children }
			</Flex>
		{ props.tca_enabled &&
			<RuleEditor
				onChange={ onRulesFieldChange }
				editData={ editData }
			/>
		}
		</Flex>
	);
}
