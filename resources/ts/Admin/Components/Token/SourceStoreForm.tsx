import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Spinner,
	SelectControl,
	Flex,
	TextareaControl,
} from '@wordpress/components';

interface SourceStoreFormProps {
	saving: boolean;
	onSubmit: any;
	onCancel: any;
	onChange: any;
	style: any;
	addresses: Array<any>,
}

interface SourceStoreFormState {
	address: number;
	assets: string;
	addressOptions: Array<any>;
	
}

export class SourceStoreForm extends Component<SourceStoreFormProps, SourceStoreFormState> {
	state: SourceStoreFormState = {
		address: null,
		assets: null,
		addressOptions: [],
	};
	
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
		this.getCurrentAddressType = this.getCurrentAddressType.bind( this );
		this.getCurrentAddressAssets = this.getCurrentAddressAssets.bind( this );
		const options = this.props.addresses.map( ( address, index ) => {
			return {
				label: address.label,
				value: index,
			}
		} );
		this.state.addressOptions = options;
		if ( this.state.addressOptions.length > 0 ) {
			this.state.address = this.state.addressOptions[0].value;
		}
	}
	
	onSubmit() {
		const selectedAddress = this.props.addresses[this.state.address];
		if ( !selectedAddress ) {
			return;
		}
		const source = {
			address: selectedAddress.address,
			type: selectedAddress.type,
			assets: this.state.assets,
		}		
		this.props.onSubmit( source );
	}

	onCancel() {
		this.props.onCancel();
	}

	getCurrentAddressType() {
		if ( this.state.address != null ) {
			return this.props.addresses[this.state.address]?.type;
		}
	}

	getCurrentAddressAssets() {
		if ( this.state.address != null ) {
			const balances = this.props.addresses[this.state.address].balances;
			const assets = balances.map( ( balance: any ) => {
				return balance.name;
			} );
			if ( assets?.length == 0 ) {
				return 'none';
			}
			return assets.join(', ');
		}
	}

	getCurrentAddress() {
		if ( this.state.address != null ) {
			return this.props.addresses[this.state.address]?.address;
		}
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<div>
					{ this.props.addresses.length > 0 
					?	<Flex
							//@ts-ignore
							direction="column"
						>
							<SelectControl
								label="Address"
								value={ this.state.address }
								style={{width: '100%'}}
								options={ this.state.addressOptions }
								help=" Blockchain wallet address"
								onChange={ ( value: any ) => {
									this.setState( { address: value } );
									this.props.onChange( this.props.addresses[value] );
								} }
							/>
							<Flex
								//@ts-ignore
								direction="column"
								gap={0.5}
							>
								<div>Address info:</div>
								<Flex
									//@ts-ignore
									direction="column"
									gap={0}
								>
									<div><strong>Type: </strong><span>{ this.getCurrentAddressType() }</span></div>
									<div><strong>Address: </strong><span>{ this.getCurrentAddress() }</span></div>
									<div><strong>Assets: </strong><a href={ `/wp-admin/admin.php?page=tokenly-token-balance-index&address=${ this.getCurrentAddress() }` } >View balances</a></div>
								</Flex>
							</Flex>
							<TextareaControl
								label="Whitelisted assets"
								help="Comma-separated values. Leaving empty will make all assets whitelisted. Only whitelisted assets can be promised."
								value={ this.state.assets }
								onChange={ ( value: any ) => {
									this.setState( { assets: value } );
								} }
							/>
						</Flex>
					:	<Flex>
							<span style={{opacity: 0.8}}>No addresses are available for registration.</span>
						</Flex>
					}
					<Flex
						style={ { marginTop: '12px' } }
						justify="flex-start"
					>
						<Button
							isPrimary
							disabled={ this.state.address === null }
							onClick={ () => {
								this.onSubmit();
							}}
						>
							Register source
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
					</Flex>
				</div>
			</form>
		);
	}
}
