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
	loadingAddresses: boolean;
	onChange: any;
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
				label: 'Not Selected',
				value: '',
			}
		],
	};
	
	constructor( props: SourceStoreFormProps ) {
		super( props );
		this.getCurrentAddress = this.getCurrentAddress.bind( this );
		this.onAddressFieldChange = this.onAddressFieldChange.bind( this );
		this.onAssetsFieldChange = this.onAssetsFieldChange.bind( this );
	}

	getCurrentAddress() {
		if ( this.props.addresses && typeof this.props.addresses === 'object' && this.props.storeData?.address ) {
			return this.props.addresses[ this.props.storeData.address ];
		}
	}

	onAddressFieldChange( address: string ) {
		const state = Object.assign( {}, this.props.storeData );
		state.address = address;
		this.props.onChange( state );
	}

	onAssetsFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.storeData );
		state.assets = value;
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
						onChange={ this.onAddressFieldChange }
						address={ this.props.storeData?.address }
						addresses={ this.props.addresses }
						loading={ this.props.loadingAddresses }
					/>
				{ address &&
					<AddressInfo address={ address } />
				}
					<TextareaControl
						label="Whitelisted Assets"
						help="Comma-separated values. Leaving empty will make all assets whitelisted. Only whitelisted assets can be promised."
						value={ this.props.storeData?.assets }
						onChange={ this.onAssetsFieldChange }
					/>
				</Flex>
			</form>
		);
	}
}
