import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import Page from '../Page';
import AddressVerifyForm from '../../Components/Token/AddressVerifyForm';
import Preloader from '../../Components/Preloader';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import { ethers } from "ethers";

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
	Button,
	Flex,
	TextControl
} from '@wordpress/components';
import AddressInterface from '../../../Interfaces/Models/Token/AddressInterface';

declare const window: any;

interface AddressVerifyPageProps {
	//
}

export default function AddressVerifyPage( props: AddressVerifyPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );
	
	const urlParams = new URLSearchParams( window.location.search );

	const [ verifying, setVerifying ] = useState<boolean>( false );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ address, setAddress ] = useState<AddressInterface>( null );
	const [ id, setId ] = useState<string>( urlParams.get( 'address' ) );
	const [ verifyData, setVerifyData ] = useState<any>( {} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-address-index`;
	}

	function onVerifySubmit( event: any ) {
		event.preventDefault();
		setVerifying( true );
		addressRepository.verify( id, verifyData ).then( ( result: any ) => {
			setVerifying( false );
			goBack();
		} );
	}

	function onCancel() {
		goBack();
	}
	
	function onVerifyDataChange( newData: any ) {
		setVerifyData( newData );
	}

	function initSigner(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			const provider = new ethers.providers.Web3Provider( window.ethereum );
			provider.send( 'eth_requestAccounts', [] )
			.then( () => {
				const signer = provider.getSigner();
				return signer;
			} )
			.then( ( signer ) => {
				signer.signMessage( verifyData.verifyCode ).then( ( signature: string ) => {
					const state = Object.assign( {}, verifyData );
					state.signature = signature;
					setVerifyData( state );
					resolve( true );
				} ).catch();
			} )
		} );
	}

	useEffect( () => {
		setLoading( true );
		addressRepository.show( id ).then( ( addressFound: any ) => {
			const newVerifyData = {
				signature: null,
			} as any;
			setLoading( false );
			setAddress( addressFound );
			setVerifyData( newVerifyData );
		} );

	}, [] );
	
	return (
		<Page title="Address Verifier">
			<form onSubmit={ onVerifySubmit } >
				<Panel>
					<PanelHeader>
						<Preloader loading={ loading } >
							<span>Verification Form</span>
						</Preloader>
					</PanelHeader>
				{ ( !loading && address ) &&
					<PanelBody>
						<PanelRow>
							<Flex
								//@ts-ignore
								direction="column"
							>
								<TextControl
									readOnly
									label="Verification Code"
									value={ address.verifyCode }
									onClick={ ( event: any ) => {
										event.target.select();
									} }
									onChange={ () => true }
								/>
								<TextControl
									readOnly
									label="Pocket Address"
									value={ address.address }
									onClick={ ( event: any ) => {
										event.target.select();
									} }
									onChange={ () => true }
								/>
								<AddressVerifyForm
									onChange={ onVerifyDataChange }
									verifyData={ verifyData }
								/>
							</Flex>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start">
								<Button
									isPrimary
									isBusy={ verifying }
									onClick={ onVerifySubmit }
								>
									Submit
								</Button>
							{ ( window.ethereum && address?.type == 'ethereum' ) &&
								<Button
									isSecondary
									onClick={ initSigner }
								>
									Sign Message
								</Button>
							}
								<Button
									isTertiary
									onClick={ onCancel }
								>
									Cancel
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
