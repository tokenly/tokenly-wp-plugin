import * as React from 'react';
import { Component } from 'react';
import AddressInfo from './AddressInfo';
import AddressSelectField from './AddressSelectField';

import { 
	Button,
	Spinner,
	Flex,
	TextareaControl,
} from '@wordpress/components';

interface SourceStoreFormProps {
	storing: boolean;
	loadingAddresses: boolean;
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
		addressOptions: [
			{
				label: '-- select an address --',
				value: '',
			}
		],
	};
	
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.getCurrentAddress = this.getCurrentAddress.bind( this );
		this.onAddressChange = this.onAddressChange.bind( this );
	}

	getCurrentAddress() {
		if ( this.props.addresses && typeof this.props.addresses === 'object' && this.props.storeData?.address ) {
			return this.props.addresses[ this.props.storeData.address ];
		}
		
	}

	onAddressChange( address: string ) {
		const state = Object.assign( {}, this.props.storeData );
		state.address = address;
		this.props.onChange( state );
	}

	render() {

		const address = this.getCurrentAddress();
		return (
			<form style={ { width: '100%', maxWidth: "400px" } }>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<AddressSelectField
						onChange={ this.onAddressChange }
						address={ this.props.storeData?.address }
						addresses={ this.props.addresses }
						loading={ this.props.loadingAddresses }
					/>
				{ address &&
					<AddressInfo address={ address } />
				}
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
						} }
					>
						Cancel
					</Button>
				</Flex>
			</form>
		);
	}
}
