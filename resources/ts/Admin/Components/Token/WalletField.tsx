import * as React from 'react';
import { Fragment } from 'react';
import { useState } from 'react';
import { ethers } from "ethers";

import { 
	Button,
	SelectControl
} from '@wordpress/components';

interface WalletFieldProps {
	address: string;
	onChange: any;
}

declare const window: any;

export default function WalletField( props: WalletFieldProps ) {
	const [ addresses, setAddresses ] = useState<any>( [] );
	const [ opened, setOpened ] = useState<boolean>( false );

	function initWallet() {
		return new Promise( ( resolve, reject ) => {
			const provider = new ethers.providers.Web3Provider( window.ethereum );
			provider.send( 'eth_requestAccounts', [] )
			.then( ( result ) => {
				const options = getAddressOptions( result );
				setAddresses( options );
				setOpened( true );
				const signer = provider.getSigner();
				return signer;
			} );
		} );
	}

	function getAddressOptions( addresses: Array<string> ): Array<object> {
		const options = addresses.map( ( address: string ) => {
			return {
				label: address,
				value: address,
			}
		} );
		options.unshift( {
			label: 'Not selected',
			value: '',
		} );
		return options;
	}

	return (
		<Fragment>
			{ ( !opened )
			?	<Button
					isSecondary
					onClick={ initWallet }
				>
					Open Wallet
				</Button>
			:	<SelectControl
					value={ props.address }
					options={ addresses }
					onChange={ props.onChange }
				/>
			}
		</Fragment>
	);
}
