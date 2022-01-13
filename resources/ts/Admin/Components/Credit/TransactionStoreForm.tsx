import * as React from 'react';
import { Component } from 'react';
import UserSearchField from './../UserSearchField';
import GroupSelectField from './GroupSelectField';

import { 
	TextControl,
	SelectControl,
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
		newState.group_uuid = value;
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
		<form style={ { width: '100%', maxWidth: "400px" } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<GroupSelectField
					onChange={ onGroupFieldChange }
					group={ props.storeData?.group_uuid }
					groups={ props.groups }
					loading={ props.loadingGroups }
				/>
				<SelectControl
					label="Transaction Type"
					value={ props.storeData?.type }
					options={ [
						{ label: 'Debit' , value: 'debit' },
						{ label: 'Credit'  , value: 'credit'  },
					] }
					onChange={ onTypeFieldChange }
				/>
				<div>
					<label>Account
						<div style={ { opacity:0.8, marginBottom: '12px' } }>WordPress username.</div>
						<UserSearchField
							user={ props.storeData?.account }
							onChange={ onAccountFieldChange }
						/>
					</label>
				</div>
				<div>
					<label>{ getSourceLabel() }
						<div style={ { opacity:0.8, marginBottom: '12px' } }>WordPress username. (optional)</div>
						<UserSearchField
							user={ props.storeData?.source }
							onChange={ onSourceFieldChange }
						/>
					</label>
				</div>
				<TextControl
					label="Amount"
					// @ts-ignore
					type="number"
					value={ props.storeData?.amount }
					onChange={ onAmountFieldChange }
				/>
				<TextControl
					label="Reference"
					help="Extra reference data"
					value={ props.storeData?.ref }
					onChange={ onRefFieldChange }
				/>
			</Flex>
		</form>
	);
}
