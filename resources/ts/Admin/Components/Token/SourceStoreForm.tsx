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
	storing: boolean;
	loading: boolean;
	onSubmit: any;
	onCancel: any;
	onChange: any;
	style: any;
	addresses: any;
	storeData: any;
}

interface SourceStoreFormState {
	addressOptions: Array<any>;
}

export default class SourceStoreForm extends Component<SourceStoreFormProps, SourceStoreFormState> {
	state: SourceStoreFormState = {
		addressOptions: [],
	};
	
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.getCurrentAddressType = this.getCurrentAddressType.bind( this );
		this.getCurrentAddressAssets = this.getCurrentAddressAssets.bind( this );
	}

	getCurrentAddressType() {
		if ( this.props.storeData?.address != null ) {
			return this.props.addresses[ this.props.storeData?.address ]?.type;
		}
	}

	getCurrentAddressAssets() {
		if ( this.props.storeData?.address != null ) {
			const balances = this.props.addresses[ this.props.storeData?.address ].balances;
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
		if ( this.props.storeData?.address != null ) {
			return this.props.addresses[ this.props.storeData.address ]?.address;
		}
	}

	componentWillReceiveProps( nextProps: any ) {
		if ( !nextProps.addresses ) {
			return;
		}
		const options = [] as any;
		Object.keys( nextProps.addresses ).forEach( function ( key ) {
			options.push( {
				label: nextProps.addresses[ key ].label,
				value: key,
			} );
		 });
		const state = { addressOptions: options } as any;
		if ( options.length > 0 ) {
			state.address = options[0].value;
		}
		this.setState( state );
	}

	render() {
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<div>
					{ this.props.loading
						?	<Flex justify="flex-start">
								<span>Loading addresses ... </span>
								<Spinner />
							</Flex>
						:	<Flex style={ { maxWidth: "320px" } }>
							{ this.state.addressOptions.length > 0 
							?	<Flex
									//@ts-ignore
									direction="column"
								>
									<SelectControl
										label="Address"
										value={ this.props.storeData?.address }
										style={ { width: '100%' } }
										options={ this.state.addressOptions }
										help=" Blockchain wallet address"
										onChange={ ( value: any ) => {
											const state = Object.assign( {}, this.props.storeData );
											state.address = value;
											this.props.onChange( state );
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
										value={ this.props.storeData?.assets }
										onChange={ ( value: any ) => {
											const state = Object.assign( {}, this.props.storeData );
											state.assets = value;
											this.props.onChange( state );
										} }
									/>
								</Flex>
							:	<Flex>
									<span style={ { opacity: 0.8 } }>No addresses are available for registration.</span>
								</Flex>
							}
						</Flex>
					}
					<Flex
						style={ { marginTop: '12px' } }
						justify="flex-start"
					>
						<Button
							isPrimary
							disabled={ !this.props.storeData.address || this.props.storing }
							onClick={ () => {
								this.props.onSubmit();
							}}
						>
							{ this.props.storing ? 'Registering ...' : 'Register source' }
						</Button>
						{ this.props.storing === true &&
							<Spinner/>
						}
						<Button
							isTertiary
							onClick={ () => {
								this.props.onCancel();
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
