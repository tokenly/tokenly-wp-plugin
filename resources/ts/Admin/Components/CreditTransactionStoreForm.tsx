import * as React from 'react';
import { Component } from 'react';
import { UserSearchField } from './UserSearchField';

import { 
	Button,
	Spinner,
	TextControl,
	SelectControl,
	Flex,
	TextareaControl,
} from '@wordpress/components';

interface CreditTransactionStoreFormProps {
	saving: boolean;
	onSubmit: any;
	onCancel: any;
	onChange?: any;
	creditGroups: any;
	style: any;
}

interface CreditTransactionStoreFormState {
	creditGroupOptions: any;
	transaction: {
		group_uuid: string,
		type: string,
		account: string,
		amount: number,
		ref: string,
		source: string,
	}
}

export class CreditTransactionStoreForm extends Component<CreditTransactionStoreFormProps, CreditTransactionStoreFormState> {
	state: CreditTransactionStoreFormState = {
		creditGroupOptions: [],
		transaction: {
			group_uuid: null,
			type: 'debit',
			account: null,
			amount: 0,
			ref: '',
			source: null,
		}
	};
	
	constructor( props: CreditTransactionStoreFormProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
		this.getCreditGroupOptions = this.getCreditGroupOptions.bind( this );
		this.state.creditGroupOptions = this.getCreditGroupOptions();
		if ( this.state.creditGroupOptions[0] ?? null ) {
			this.state.transaction.group_uuid = this.state.creditGroupOptions[0]?.value;
		}
	}
	
	onSubmit() {
		const transaction = Object.assign( {}, this.state.transaction );
		console.log(transaction);
		this.props.onSubmit( transaction );
	}

	onCancel() {
		this.props.onCancel();
	}

	getCreditGroupOptions() {
		const options = [] as any;
		this.props.creditGroups.forEach( ( creditGroup: any ) => {
			options.push( {
				label: creditGroup.name,
				value: creditGroup.uuid,
			} );
		} );
		return options;
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<div>
					<Flex
						//@ts-ignore
						direction="column"
					>
						<div
							style={{marginBottom: '12px'}}
						>
							<SelectControl
								label="Credit group"
								value={ this.state.transaction.group_uuid }
								options={ this.state.creditGroupOptions }
								onChange={ ( value: string ) => {
									let newState = Object.assign( {}, this.state.transaction );
									newState.group_uuid = value;
									this.setState( { transaction: newState } );
								} }
							/>
						</div>
						<div
							style={{marginBottom: '12px'}}
						>
							<SelectControl
								label="Transaction type"
								value={ this.state.transaction.type }
								
								options={ [
									{ label: 'Debit' , value: 'debit' },
									{ label: 'Credit'  , value: 'credit'  },
								] }
								onChange={ ( value: string ) => {
									let newState = Object.assign( {}, this.state.transaction );
									newState.type = value;
									this.setState( { transaction: newState } );
								} }
							/>
						</div>
						<div>
							<label>Account
								<div style={{opacity:0.8, marginBottom: '12px'}}>WordPress username.</div>
								<UserSearchField
									onChange={ ( value: any ) => {
										const state = Object.assign( {}, this.state.transaction );
										state.account = value;
										this.setState( { transaction: state } );
									} }
								/>
							</label>
						</div>
						<div>
							<label>Source
								<div style={{opacity:0.8, marginBottom: '12px'}}>WordPress username. (optional)</div>
								<UserSearchField
									onChange={ ( value: any ) => {
										const state = Object.assign( {}, this.state.transaction );
										state.source = value;
										this.setState( { transaction: state } );
									} }
								/>
							</label>
						</div>
						<TextControl
							label="Amount"
							// @ts-ignore
							type="number"
							value={ this.state.transaction.amount }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.state.transaction );
								state.amount = value;
								this.setState( { transaction: state } );
							} }
						/>
						<TextControl
							label="Ref"
							help="Extra reference data"
							value={ this.state.transaction.ref }
							onChange={ (value: any) => {
								const state = Object.assign( {}, this.state.transaction );
								state.ref = value;
								this.setState( { transaction: state } );
							} }
						/>
					</Flex>
					<Flex
						style={ { marginTop: '12px' } }
						justify="flex-start"
					>
						<Button
							isPrimary 
							onClick={ () => {
								this.onSubmit();
							}}
						>
							Make transaction
						</Button>
						{this.props.saving === true &&
							<Spinner/>
						}
						<Button
							isTertiary
							disabled={ this.props.saving }
							onClick={ () => {
								this.onCancel();
							}}
							
						>
							Cancel
						</Button>
						{this.props.saving === true &&
							<Spinner/>
						}
					</Flex>
				</div>
			</form>
		);
	}
}