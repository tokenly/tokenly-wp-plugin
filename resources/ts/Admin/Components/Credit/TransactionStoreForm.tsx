import * as React from 'react';
import UserSearchField from '../UserSearchField';
import GroupSelectField from './GroupSelectField';
import TransactionTypeField from './TransactionTypeField';

import { 
	TextControl,
	Flex,
} from '@wordpress/components';

interface TransactionStoreFormProps {
	storeData: any;
	onChange: any;
	groups: any;
	loadingGroups: boolean;
}

export default function TransactionStoreForm( props: TransactionStoreFormProps ) {
	function getSourceLabel() {
		let label = '';
		switch ( props.storeData?.type ) {
			case 'debit':
				label = 'Destination';
				break;
			case 'credit':
				label = 'Source';
				break;
		}
		return label;
	}

	function onGroupFieldChange( value: any ) {
		const newState = Object.assign( {}, props.storeData );
		newState.groupUuid = value;
		props.onChange( newState );
	}

	function onTypeFieldChange( value: any ) {
		const newState = Object.assign( {}, props.storeData );
		newState.type = value;
		props.onChange( newState );
	}

	function onAccountFieldChange( value: any ) {
		const newState = Object.assign( {}, props.storeData );
		newState.account = value;
		props.onChange( newState );
	}

	function onSourceFieldChange( value: any ) {
		const newState = Object.assign( {}, props.storeData );
		newState.source = value;
		props.onChange( newState );
	}

	function onAmountFieldChange( value: any ) {
		const newState = Object.assign( {}, props.storeData );
		newState.amount = value;
		props.onChange( newState );
	}

	function onRefFieldChange( value: any ) {
		const newState = Object.assign( {}, props.storeData );
		newState.ref = value;
		props.onChange( newState );
	}

	return (
		<Flex
			//@ts-ignore
			direction="column"
			style={ { width: '100%', maxWidth: "400px" } }
		>
			<GroupSelectField
				label="Group *"
				onChange={ onGroupFieldChange }
				group={ props.storeData?.groupUuid }
				groups={ props.groups }
				loading={ props.loadingGroups }
				inputProps={ {
					required: true,
				} }
			/>
			<TransactionTypeField
				label="Transaction Type	*"
				type={ props.storeData?.type }
				onChange={ onTypeFieldChange }
				inputProps={ {
					required: true,
				} }
			/>
			<UserSearchField
				label="Account *"
				help="WordPress / Tokenpass name / Tokenpass UUID."
				user={ props.storeData?.account }
				onChange={ onAccountFieldChange }
				inputProps={ {
					required: true,
				} }
			/>
			<UserSearchField
				label={ getSourceLabel() }
				help="WordPress / Tokenpass name / Tokenpass UUID."
				user={ props.storeData?.source }
				onChange={ onSourceFieldChange }
			/>
			<TextControl
				label="Amount *"
				// @ts-ignore
				type="number"
				value={ props.storeData?.amount }
				onChange={ onAmountFieldChange }
				required
			/>
			<TextControl
				label="Reference"
				help="Extra reference data"
				value={ props.storeData?.ref }
				onChange={ onRefFieldChange }
			/>
		</Flex>
	);
}
