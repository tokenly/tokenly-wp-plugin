import * as React from 'react';
import { useState, useEffect } from 'react';
import RuleEditor from '../Components/Token/Access/RuleEditor';

import { 
	Flex,
} from '@wordpress/components';
import RuleCollection from '../../Collections/Token/RuleCollection';

export interface PostEditPageProps {
	tca_rules: any;
	tca_enabled: boolean;
	children: any;
	onPostDataChange: any;
}

export default function PostEditPage( props: PostEditPageProps ) {
	const [ editData, setEditData ] = useState<any>( {
		tcaRules: ( new RuleCollection() ).fromJson( props.tca_rules )
	} );

	function onEditDataChange( newData: any ) {
		setEditData( newData );
		const rules = newData.tcaRules.toJson()
		console.log(rules)
		props.onPostDataChange( {
			tca_rules: rules
		} );
	}

	function onRulesFieldChange( newRules: any ) {
		let state = Object.assign( {}, editData );
		state.tcaRules = newRules;
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
