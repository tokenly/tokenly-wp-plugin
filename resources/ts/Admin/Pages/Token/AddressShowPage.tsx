import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import Page from './../Page';
import Preloader from '../../Components/Preloader';
import AddressInfo from '../../Components/Token/AddressInfo';
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

	const urlParams = new URLSearchParams( window.location.search );
	const [ id, setId ] = useState<string>( urlParams.get( 'address' ) );
	const [ address, setAddress ] = useState<any>( null );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ deleting, setDeleting ] = useState<boolean>( false );

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice );
		setLoading( true );
		addressRepository.show( id ).then( ( addressFound: any ) => {
			setLoading( false );
			setAddress( addressFound );
		} );
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice );
		}
	 }, [] );

	 function onDelete() {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'addressDelete',
			title: 'Deleting Address',
			subtitle: 'Are you sure you want to delete the address?',
		} );
	}

	function deleteAddress() {
		setDeleting( true );
		addressRepository.destroy( id ).then( ( result: any ) => {
			setDeleting( false );
			goBack();
		} );
	}

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-address-index`;
	}

	function onConfirmModalChoice( payload: any ) {
		switch( payload.key ) {
			case 'addressDelete':
				if ( payload.choice == 'accept' ){
					deleteAddress();
				}
				break;
		}
	}
	
	return (
		<Page title="Address Display">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loading }>Address Info</Preloader>
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
