import * as React from 'react';
import { Component } from 'react';
import UserSearchField from './../UserSearchField';
import AssetSearchField from './../AssetSearchField';
import SourceSelectField from './../Token/SourceSelectField';
import QuantityField from './../Token/QuantityField';

import { 
	TextControl,
	TextareaControl,
	Flex,
	CheckboxControl,
} from '@wordpress/components';

interface PromiseStoreFormProps {
	loadingSources: boolean;
	storeData: any;
	sources: any;
	onChange: any;
}

interface PromiseStoreFormState {
	//
}

export default class PromiseStoreForm extends Component<PromiseStoreFormProps, PromiseStoreFormState> {
	state: PromiseStoreFormState = {
		//
	};
	constructor( props: PromiseStoreFormProps ) {
		super( props );
		this.getBalance = this.getBalance.bind( this );
		this.getCurrentAssetBalance = this.getCurrentAssetBalance.bind( this );
		this.getMaxCount = this.getMaxCount.bind( this );
		this.isAssetValid = this.isAssetValid.bind( this );
		this.onDestinationFieldChange = this.onDestinationFieldChange.bind( this );
		this.onSourceFieldChange = this.onSourceFieldChange.bind( this );
		this.onPseudoFieldChange = this.onPseudoFieldChange.bind( this );
		this.onAssetFieldChange = this.onAssetFieldChange.bind( this );
		this.onQuantityFieldChange = this.onQuantityFieldChange.bind( this );
		this.onRefFieldChange = this.onRefFieldChange.bind( this );
		this.onNoteFieldChange = this.onNoteFieldChange.bind( this );
	}

	getBalance() {
		const options = [] as any;
		if ( !this.props.storeData?.source_id ) {
			return [];
		}
		const balance = this.props.sources[ this.props.storeData?.source_id ]?.address?.balance;
		return balance;
	}

	getCurrentAssetBalance() {
		if ( !this.props.storeData?.asset ) {
			return null;
		}
		const asset = this.props.storeData.asset;
		if ( asset == '' ) {
			return null;
		}
		let balance = this.props.sources[ this.props.storeData?.source_id ]?.address?.balance;
		if ( !balance ) {
			return null;
		}
		balance = Object.values( balance );
		balance = balance.filter( ( balance: any ) => {
			return balance.asset === this.props.storeData?.asset;
		} );
		if ( balance.length == 0 ) {
			return null;
		}
		return balance[0];
	}

	getMaxCount() {
		const balance = this.getCurrentAssetBalance();
		if ( !balance ) {
			return 0;
		}
		const quantity = parseFloat( balance.quantity.value );
		return quantity;
	}

	isAssetValid() {
		const balance = this.getCurrentAssetBalance();
		if ( balance || this.props.storeData?.pseudo == true ) {
			return true;
		}
		return false;
	}

	onDestinationFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.destination = value;
		this.props.onChange( state );
	}

	onSourceFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.source_id = value;
		this.props.onChange( state );
	}

	onPseudoFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.pseudo = value;
		state.asset = null;
		state.quantity = 0;
		this.props.onChange( state );
	}

	onAssetFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.asset = value;
		this.props.onChange( state );
	}

	onQuantityFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.quantity = value;
		this.props.onChange( state );
	}

	onRefFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.ref = value;
		this.props.onChange( state );
	}

	onNoteFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.note = value;
		this.props.onChange( state );
	}

	render() {
		return (
			<form style={ { width: '100%' } }>
				{ this.props.storeData
			?	<Flex
					//@ts-ignore
					direction="column"
					style={ { maxWidth: '320px' } }
				>
					<SourceSelectField
						onChange={ this.onSourceFieldChange }
						source={ this.props.storeData?.source_id }
						sources={ this.props.sources }
						loading={ this.props.loadingSources }
					/>
					<div>
						<label>
							<div>Destination</div>
							<div style={ { opacity:0.8, marginBottom: '12px' } }>WordPress username. The user who will receive the asset.</div>
							<UserSearchField onChange={ this.onDestinationFieldChange } />
						</label>
					</div>
					<div>
						<CheckboxControl
							label="Pseudo promise"
							help="Pseudo promises allow arbitrary asset names"
							checked={ this.props.storeData.pseudo }
							onChange={ this.onPseudoFieldChange }
						/>
					</div>
				{ this.props.storeData.source_id &&
					<div>
						<label>
							<div>Asset</div>
							<div style={ { opacity: 0.8, marginBottom: '12px' } }>
								<div>Name of the asset that will be promised.</div>
								<div>Note: Only the whitelisted assets are searchable.</div>
							</div>
							{ ( !this.props.storeData?.pseudo || this.props.storeData?.pseudo == false )
								?	<AssetSearchField
										assets={ this.getBalance() }
										asset={ this.props.storeData?.asset }
										onChange={ this.onAssetFieldChange }
									/>
								:	<TextControl
										value={ this.props.storeData.asset }
										onChange={ this.onAssetFieldChange }
									/>
							}
						</label>
					</div>
				}
				{ this.isAssetValid() &&
					<Flex
						//@ts-ignore
						direction="column"
					>
						<QuantityField
							quantity={ this.props.storeData?.quantity }
							onChange={ this.onQuantityFieldChange }
							max={ this.getMaxCount() }
						/>
						<TextControl
							label="Ref"
							help="Extra reference data"
							value={ this.props.storeData?.ref }
							onChange={ this.onRefFieldChange }
						/>
						<TextareaControl
							label="Note"
							help="Note to display to user"
							value={ this.props.storeData?.note }
							onChange={ this.onNoteFieldChange }
						/>
					</Flex>
				}
				</Flex>
			: 	<div style={{opacity: 0.8}}>No sources registered.</div>
			}
			</form>
		);
	}
}
