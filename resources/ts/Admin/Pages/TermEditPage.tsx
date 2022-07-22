import * as React from 'react'
import { useState, useEffect } from 'react'
import FormTable from '../Components/FormTable'
import RuleEditor from '../Components/Token/Access/RuleEditor'
import RuleCollection from '../../Collections/Token/RuleCollection'

import { 
	Flex,
} from '@wordpress/components'

export interface TermEditPageProps {
	tca_rules: any
	tca_enabled: boolean
	children: any
	onPostDataChange: any
}

export default function TermEditPage( props: TermEditPageProps ) {
	const [ editData, setEditData ] = useState<any>( {
		tcaRules: ( new RuleCollection() ).fromJson( props.tca_rules )
	} )

	function onEditDataChange( newData: any ) {
		setEditData( newData )
		const rules = newData.tcaRules.toJson()
		props.onPostDataChange( {
			tca_rules: rules
		} )
	}

	function onRulesFieldChange( newRules: any ) {
		let state = Object.assign( {}, editData )
		state.tcaRules = newRules
		onEditDataChange( state )
	}

	useEffect( () => {
		props.onPostDataChange( editData )
	}, [] )

	return (
		<Flex
			//@ts-ignore
			direction="column"
			gap={ 4 }
		>
			<Flex
				//@ts-ignore
				direction="column"
				gap={ 4 }
			>
				{ props.children }
			</Flex>
		{ props.tca_enabled &&
			<FormTable
				rows={
					[
						{
							label: 'Access Rules',
							component:
								<RuleEditor
									onChange={ onRulesFieldChange }
									editData={ editData }
								/>
						},
					]
				}
			/>
		}
		</Flex>
	)
}
