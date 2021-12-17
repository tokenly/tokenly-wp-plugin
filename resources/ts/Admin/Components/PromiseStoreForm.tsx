import * as React from 'react';
import { Component } from 'react';
import { PromiseStoreParams, SourceItem } from '../../Interfaces';
import { UserSearchField } from './UserSearchField';
import { AssetSearchField } from './AssetSearchField';

import { 
	Button,
	Spinner,
	TextControl,
	TextareaControl,
	SelectControl,
	Flex,
	CheckboxControl,
	// @ts-ignore
	__experimentalNumberControl as NumberControl
} from '@wordpress/components';

interface PromiseStoreFormProps {
	saving: boolean;
	onSubmit: any;
	onCancel: any;
	style: any;
	sources: Array<SourceItem>;
}

interface PromiseStoreFormState {
	promise: PromiseStoreParams;
	source: any;
	sources: Array<string>;
}

export class PromiseStoreForm extends Component<PromiseStoreFormProps, PromiseStoreFormState> {
	state: PromiseStoreFormState = {
		promise: {
			source_id: null,
			destination: null,
			asset: null,
			pseudo: false,
			quantity: 0,
			ref: null,
			note: null,
		},
		source: null,
		sources: [],
	};
	constructor( props: PromiseStoreFormProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
		this.onCancel = this.onCancel.bind( this );
		this.onUserChange = this.onUserChange.bind( this );
		this.onSourceChange = this.onSourceChange.bind( this );
		this.getSourceOptions = this.getSourceOptions.bind( this );
		this.getAssetOptions = this.getAssetOptions.bind( this );
		this.getCurrentAsset = this.getCurrentAsset.bind( this );
		this.getMaxCount = this.getMaxCount.bind( this );
		this.isAssetValid = this.isAssetValid.bind( this );
		if ( Object.keys( this.props.sources ).length > 0 ) {
			const key = Object.keys( this.props.sources )[0] as any;
			this.state.source = Object.assign( {}, this.props.sources[ key ] ?? null );
			this.state.promise.source_id = this.state.source.address_id;
		}
	}
	
	onSubmit() {
		this.props.onSubmit( this.state.promise );
	}

	onCancel() {
		this.props.onCancel( this.state.promise );
	}

	onSourceChange( value: any ) {
		const state = Object.assign( {}, this.state.promise );
		state.source_id = value;
		state.asset = null;
		state.quantity = 0;
		const source = Object.assign( {}, this.props.sources[ value ] ?? null );
		this.setState( {
			promise: state,
			source: source ?? null,
		} );
	}
	
	onUserChange( userId: number ) {
		const promise = Object.assign( {}, this.state.promise );
		promise.destination = userId;
		this.setState( { promise: promise } );
	}

	getSourceOptions() {
		const options = [] as any;
		Object.keys( this.props.sources ).forEach( ( key: any ) => {
			const label = this.props.sources[ key ].address.label ?? this.props.sources[ key ].address_id ?? null;
			options.push( {
				label: label,
				value: key,
			} );
		});
		return options;
	}

	getAssetOptions() {
		const options = [] as any;
		if ( !this.state.source ) {
			return [];
		}
		const balance = this.state.source?.address?.balance;
		if ( !balance ) {
			return [];
		}
		Object.keys( balance ).forEach( ( key: any ) => {
			let asset = balance[ key ].asset;
			options.push( asset );
		} );
		return options;
	}

	getCurrentAsset() {
		if ( !this.state.promise?.asset ) {
			return null;
		}
		const asset = this.state.promise.asset;
		if ( asset == '' ) {
			return null;
		}
		let balance = this.state.source.address.balance;
		balance = Object.values( balance );
		balance = balance.filter( ( balance: any ) => {
			return balance.asset === this.state.promise.asset;
		} );
		if ( balance.length == 0 ) {
			return null;
		}
		return balance[0];
		
	}

	getMaxCount() {
		const asset = this.getCurrentAsset();
		if ( !asset ) {
			return null;
		}
		const quantity = parseFloat( asset.quantity.value );
		return quantity;
	}

	isAssetValid() {
		const asset = this.getCurrentAsset();
		if ( asset || this.state?.promise?.pseudo == true ) {
			return true;
		}
		return false;
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: '320px' } }>
				<Flex
					//@ts-ignore
					direction="column"
					style={ { width: '100%' } }
				>
					<SelectControl
						label="Source"
						value={ this.state.promise.source_id }
						options={ this.getSourceOptions() }
						onChange={ ( value: any ) => {
							this.onSourceChange( value );
						} }
						help="Source address to use."
					/>
					<div>
						<label>Destination
							<div style={{opacity:0.8, marginBottom: '12px'}}>WordPress username. The user who will receive the asset.</div>
							<UserSearchField
								onChange={ ( value: any ) => {
									const state = Object.assign( {}, this.state.promise );
									state.destination = value;
									this.setState( { promise: state } );
								} }
							/>
						</label>
					</div>
					<div>
						<CheckboxControl
							label="Pseudo promise"
							help="Pseudo promises allow arbitrary asset names"
							checked={ this.state.promise.pseudo }
							onChange={ ( value: any ) => {
								const state = Object.assign( {}, this.state.promise );
								state.pseudo = value;
								state.asset = null;
								state.quantity = 0;
								this.setState( { promise: state } );
							} }
						/>
					</div>
					<div>
						<label>Asset
							<div style={ { opacity: 0.8, marginBottom: '12px' } }>
								<div>Name of the asset that will be promised.</div>
								<div>Note: Only the whitelisted assets are searchable.</div>
							</div>
							{ this.state.promise.pseudo == false
								?	<AssetSearchField
										assets={ this.getAssetOptions() }
										value={ this.state.promise.asset }
										onChange={ ( value: any ) => {
											const state = Object.assign( {}, this.state.promise );
											state.asset = value;
											this.setState( { promise: state } );
										} }
									/>
								:	<TextControl
										value={ this.state.promise.asset }
										onChange={ (value: any) => {
											const state = Object.assign( {}, this.state.promise );
											state.asset = value;
											this.setState( { promise: state } );
										} }
									/>
							}
						</label>
					</div>
					{ this.isAssetValid() &&
						<div>
							<label>
								Quantity
								<Flex justify="flex-start" align="center" style={ { paddingTop: '12px' } }>
									<TextControl
										type="number"
										value={ this.state.promise.quantity }
										min={ 0 }
										style={ { maxWidth: '100px' } }
										onChange={ (value: any) => {
											const state = Object.assign( {}, this.state.promise );
											state.quantity = value;
											this.setState( { promise: state } );
										} }
									/>
									{ this.state.promise.pseudo == false &&
										<span>
											<span>of / </span>
											<span title={ this.getMaxCount() as any }>
												<strong>{ parseFloat( this.getMaxCount().toFixed( 4 ) ) }</strong>
											</span>
										</span>
									}
								</Flex>
							</label>
							<TextControl
								label="Ref"
								help="Extra reference data"
								value={ this.state.promise.ref }
								onChange={ (value: any) => {
									const state = Object.assign( {}, this.state.promise );
									state.ref = value;
									this.setState( { promise: state } );
								} }
							/>
							<TextareaControl
								label="Note"
								help="Note to display to user"
								value={ this.state.promise.note }
								onChange={ ( value: any ) => {
									const state = Object.assign( {}, this.state.promise );
									state.note = value;
									this.setState( { promise: state } );
								} }
							/>
						</div>
					}
				</Flex>
				<Flex justify="flex-start">
					<Button
						isPrimary
						disabled={ this.props.saving }
						onClick={ () => {
							this.onSubmit();
						}}
						style={ { marginTop: '12px' } }
					>
						Create promise
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
						style={ { marginTop: '12px' } }
					>
						Cancel
					</Button>
				</Flex>
			</form>
		);
	}
}
