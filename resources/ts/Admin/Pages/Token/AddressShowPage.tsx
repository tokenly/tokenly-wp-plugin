import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import Page from './../Page';
import Preloader from '../../Components/Preloader';
import AddressInfo from '../../Components/Token/AddressInfo';
import AddressStatus from '../../Components/Token/AddressStatus';
import eventBus from "../../../EventBus";

declare const window: any;

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
	Button,
	Flex,
} from '@wordpress/components';

interface AddressShowPageProps {
	//
}

export default function AddressShowPage( props: AddressShowPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );

	const urlParams = new URLSearchParams( window.location.search );
	const [ id, setId ] = useState<string>( urlParams.get( 'address' ) );
	const [ address, setAddress ] = useState<any>( null );
	const [ sources, setSources ] = useState<any>( null );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false );
	const [ deleting, setDeleting ] = useState<boolean>( false );

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice );
		setLoading( true );
		setLoadingSources( true );
		addressRepository.show( id )
			.then( ( addressFound: any ) => {
				setLoading( false );
				setAddress( addressFound );
				return addressFound;
			} )
			.then( ( addressFound ) => {
				sourceRepository.index()
			.then( ( result: any ) => {
				setLoadingSources( false );
				setSources( result );
				addressFound = Object.assign( {}, addressFound );
				addressFound.isSource = ( id in result );
				setAddress( addressFound );
			} ) } );
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice );
		}
	 }, [] );

	 function onDelete(): void {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'addressDelete',
			title: 'Deleting Address',
			subtitle: 'Are you sure you want to delete the address?',
		} );
	}

	function deleteAddress(): void {
		setDeleting( true );
		addressRepository.destroy( id ).then( ( result: any ) => {
			setDeleting( false );
			goBack();
		} );
	}

	function goBack(): void {
		window.location = `${adminPageUrl}${namespace}-token-address-index`;
	}

	function onConfirmModalChoice( payload: any ): void {
		switch( payload.key ) {
			case 'addressDelete':
				if ( payload.choice == 'accept' ){
					deleteAddress();
				}
				break;
		}
	}

	function isSource(): boolean {
		return ( id && sources && id in sources );
	}
	
	return (
		<Page title="Address Display">
			<Panel>
				<PanelHeader>
					<Flex
						justify="flex-start"
					>
						<Preloader loading={ ( loading || loadingSources ) }>
							<Flex justify="flex-start">
								<span style={ { flexShrink: 0 } }>Address Info</span>
								{ ( !loading && !loadingSources ) && <AddressStatus address={ address } /> }
							</Flex>
						</Preloader>
					</Flex>
				</PanelHeader>
			{ ( !loading && address ) &&
				<PanelBody>
					<PanelRow>
						<AddressInfo address={ address } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<Flex justify="flex-start">
							<Button
								isSecondary
								isLarge
								href={ `${adminPageUrl}${namespace}-token-address-edit&address=${id}` }
							>
								Edit Address
							</Button>
							<Button
								isSecondary
								isLarge
								href={ `${adminPageUrl}${namespace}-token-address-balance-index&id=${id}` }
							>
								View Balance
							</Button>
							<Button
								isSecondary
								isLarge
								disabled={ ( !sources || !isSource() ) }
								href={ `${adminPageUrl}${namespace}-token-source-show&source=${id}` }
							>
								View Source
							</Button>
							<Button
								isSecondary
								isLarge
								disabled={ ( !sources || isSource() ) }
								href={ `${adminPageUrl}${namespace}-token-source-store&address=${id}` }
							>
								Make Source
							</Button>
							<Button
								isSecondary
								isLarge
								disabled={ address?.verified ?? true }
								href={ `${adminPageUrl}${namespace}-token-address-verify&address=${id}` }
							>
								Verify Address
							</Button>
							<Button
								isDestructive
								isLarge
								isBusy={ deleting }
								onClick={ onDelete }
							>
								Delete Address
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
