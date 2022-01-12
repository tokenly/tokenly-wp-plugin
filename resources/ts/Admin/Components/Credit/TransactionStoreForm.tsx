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

interface TransactionStoreFormState {
	groupOptions: any;
}

export default class TransactionStoreForm extends Component<TransactionStoreFormProps, TransactionStoreFormState> {
	state: TransactionStoreFormState = {
		groupOptions: [],
	};
	
	constructor( props: TransactionStoreFormProps ) {
		super( props );
		this.getSourceLabel = this.getSourceLabel.bind( this );
		this.onGroupFieldChange = this.onGroupFieldChange.bind( this );
		this.onTypeFieldChange = this.onTypeFieldChange.bind( this );
		this.onAccountFieldChange = this.onAccountFieldChange.bind( this );
		this.onSourceFieldChange = this.onSourceFieldChange.bind( this );
		this.onAmountFieldChange = this.onAmountFieldChange.bind( this );
		this.onRefFieldChange = this.onRefFieldChange.bind( this );
	}

	getSourceLabel() {
		let label = '';
		switch ( this.props.storeData?.type ) {
			case 'debit':
				label = 'Destination';
				break;
			case 'credit':
				label = 'Source';
				break;
		}
		return label;
	}

	onGroupFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.storeData );
		newState.group_uuid = value;
		this.props.onChange( newState );
	}

	onTypeFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.storeData );
		newState.type = value;
		this.props.onChange( newState );
	}

	onAccountFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.storeData );
		newState.account = value;
		this.props.onChange( newState );
	}

	onSourceFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.storeData );
		newState.source = value;
		this.props.onChange( newState );
	}

	onAmountFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.storeData );
		newState.amount = value;
		this.props.onChange( newState );
	}

	onRefFieldChange( value: any ) {
		const newState = Object.assign( {}, this.props.storeData );
		newState.ref = value;
		this.props.onChange( newState );
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<GroupSelectField
						onChange={ this.onGroupFieldChange }
						group={ this.props.storeData?.group_uuid }
						groups={ this.props.groups }
						loading={ this.props.loadingGroups }
					/>
					<SelectControl
						label="Transaction Type"
						value={ this.props.storeData?.type }
						options={ [
							{ label: 'Debit' , value: 'debit' },
							{ label: 'Credit'  , value: 'credit'  },
						] }
						onChange={ this.onTypeFieldChange }
					/>
					<div>
						<label>Account
							<div style={ { opacity:0.8, marginBottom: '12px' } }>WordPress username.</div>
							<UserSearchField
								user={ this.props.storeData?.account }
								onChange={ this.onAccountFieldChange }
							/>
						</label>
					</div>
					<div>
						<label>{ this.getSourceLabel() }
							<div style={ { opacity:0.8, marginBottom: '12px' } }>WordPress username. (optional)</div>
							<UserSearchField
								user={ this.props.storeData?.source }
								onChange={ this.onSourceFieldChange }
							/>
						</label>
					</div>
					<TextControl
						label="Amount"
						// @ts-ignore
						type="number"
						value={ this.props.storeData?.amount }
						onChange={ this.onAmountFieldChange }
					/>
					<TextControl
						label="Reference"
						help="Extra reference data"
						value={ this.props.storeData?.ref }
						onChange={ this.onRefFieldChange }
					/>
				</Flex>
			</form>
		);
	}
}
