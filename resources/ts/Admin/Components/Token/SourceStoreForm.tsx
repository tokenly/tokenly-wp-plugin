import * as React from 'react';
import { useState } from 'react';
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

export default function SourceStoreForm( props: SourceStoreFormProps ) {
	const [ addressOptions, setAddressOptions ] = useState( [
		{
			label: 'Not Selected',
			value: '',
		}
	] );

	function getCurrentAddress() {
		if ( props.addresses && typeof props.addresses === 'object' && props.storeData?.address ) {
			return props.addresses[ props.storeData.address ];
		}
	}

	function onAddressFieldChange( address: string ) {
		const state = Object.assign( {}, props.storeData );
		state.address = address;
		props.onChange( state );
	}

	function onAssetsFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData );
		state.assets = value;
		props.onChange( state );
	}  

	const address = getCurrentAddress();
	return (
		<form style={ { width: '100%', maxWidth: "400px" } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<AddressSelectField
					onChange={ onAddressFieldChange }
					address={ props.storeData?.address }
					addresses={ props.addresses }
					loading={ props.loadingAddresses }
				/>
			{ address &&
				<AddressInfo address={ address } />
			}
				<TextareaControl
					label="Whitelisted Assets"
					help="Comma-separated values. Leaving empty will make all assets whitelisted. Only whitelisted assets can be promised."
					value={ props.storeData?.assets }
					onChange={ onAssetsFieldChange }
				/>
			</Flex>
		</form>
	);
}
